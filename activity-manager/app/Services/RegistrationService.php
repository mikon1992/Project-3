<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ActivityService
{
    public function create(array $data, ?UploadedFile $poster = null): Activity
    {
        $newPoster = null;

        try {
            if ($poster) {
                $newPoster = $poster->store('posters', 'public');
                $data['poster_path'] = $newPoster;
            }

            // Status sengaja tidak dimasukkan dari request umum.
            return Activity::create($data);
        } catch (\Throwable $e) {
            if ($newPoster) {
                Storage::disk('public')->delete($newPoster);
            }

            throw $e;
        }
    }

    public function update(Activity $activity, array $data, ?UploadedFile $poster = null): Activity
    {
        $oldPoster = $activity->poster_path;
        $newPoster = null;

        try {
            if ($poster) {
                $newPoster = $poster->store('posters', 'public');
                $data['poster_path'] = $newPoster;
            }

            $activity->update($data);

            if ($newPoster && $oldPoster && $oldPoster !== $newPoster) {
                Storage::disk('public')->delete($oldPoster);
            }

            return $activity->refresh();
        } catch (\Throwable $e) {
            if ($newPoster) {
                Storage::disk('public')->delete($newPoster);
            }

            throw $e;
        }
    }

    public function publish(Activity $activity): Activity
    {
        if ($activity->status !== 'draft') {
            throw ValidationException::withMessages([
                'status' => 'Hanya kegiatan draft yang dapat dipublikasikan.',
            ]);
        }

        $validator = Validator::make($activity->toArray(), [
            'category_id' => ['required', 'exists:categories,id'],
            'code' => ['required'],
            'title' => ['required'],
            'location' => ['required'],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date', 'after_or_equal:start_at'],
            'capacity' => ['required', 'integer', 'min:1', 'max:500'],
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages([
            ]);
        }

        $activity->update(['status' => 'published']);

        return $activity->refresh();
    }

    public function complete(Activity $activity): Activity
    {
        if ($activity->status !== 'published') {
            throw ValidationException::withMessages([
                'status' => 'Hanya kegiatan published yang dapat diselesaikan.',
            ]);
        }

        $activity->update(['status' => 'completed']);

        return $activity->refresh();
    }

    public function delete(Activity $activity): void
    {
        $activity->delete();
    }

    public function restore(int $activityId): Activity
    {
        $activity = Activity::onlyTrashed()->findOrFail($activityId);
        $activity->restore();

        return $activity->refresh();
    }
}
