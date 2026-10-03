<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivitySpecialChallengeTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_is_required_and_valid(): void
    {
        $category = Category::factory()->create();

        $response = $this->post(route('activities.store'), [
            'category_id' => $category->id,
            'code' => 'ACT-001',
            'title' => 'Activity Valid',
            'description' => 'Test',
            'start_at' => now()->addDay()->format('Y-m-d H:i'),
            'end_at' => now()->addDay()->addHours(2)->format('Y-m-d H:i'),
            'location' => 'Lab',
            'capacity' => 50,
        ]);

        $response->assertRedirect(route('activities.index'));
        $this->assertDatabaseHas('activities', ['code' => 'ACT-001']);
    }

    public function test_duplicate_code_is_rejected(): void
    {
        $category = Category::factory()->create();
        Activity::factory()->create(['category_id' => $category->id, 'code' => 'ACT-001']);

        $response = $this->from(route('activities.create'))
            ->post(route('activities.store'), [
                'category_id' => $category->id,
                'code' => 'ACT-001',
                'title' => 'Duplikat',
                'start_at' => now()->addDay()->format('Y-m-d H:i'),
                'end_at' => now()->addDay()->addHours(2)->format('Y-m-d H:i'),
                'location' => 'Lab',
                'capacity' => 10,
            ]);

        $response->assertSessionHasErrors('code');
    }

    public function test_category_in_use_cannot_be_deleted(): void
    {
        $category = Category::factory()->create();
        Activity::factory()->create(['category_id' => $category->id]);

        $response = $this->delete(route('categories.destroy', $category));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_completed_cannot_return_to_draft_via_generic_update(): void
    {
        $category = Category::factory()->create();
        $activity = Activity::factory()->create([
            'category_id' => $category->id,
            'status' => 'completed',
        ]);

        // Status tidak menjadi field update request, sehingga tidak bisa dipaksa lewat form umum.
        $this->put(route('activities.update', $activity), [
            'category_id' => $category->id,
            'code' => $activity->code,
            'title' => 'Updated',
            'start_at' => $activity->start_at->format('Y-m-d H:i'),
            'end_at' => $activity->end_at->format('Y-m-d H:i'),
            'location' => $activity->location,
            'capacity' => $activity->capacity,
            'status' => 'draft',
        ]);

        $this->assertDatabaseHas('activities', ['id' => $activity->id, 'status' => 'completed']);
    }

    public function test_soft_delete_and_restore_work(): void
    {
        $category = Category::factory()->create();
        $activity = Activity::factory()->create(['category_id' => $category->id]);

        $this->delete(route('activities.destroy', $activity));
        $this->assertSoftDeleted('activities', ['id' => $activity->id]);

        $this->post(route('activities.restore', $activity->id));
        $this->assertDatabaseHas('activities', ['id' => $activity->id, 'deleted_at' => null]);
    }
}
