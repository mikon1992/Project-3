document.addEventListener('DOMContentLoaded', () => {
    const selector = document.querySelector('#area_id')
    const output = document.querySelector('#area-summary')

    if (!selector || !output) return

    selector.addEventListener('change', async event => {
        const areaId = event.target.value
        output.hidden = false
        output.textContent = 'Memuat ringkasan area…'

        if (!areaId) {
            output.hidden = true
            return
        }

        try {
            const response = await fetch(`/areas/${encodeURIComponent(areaId)}/summary`, {
                headers: { Accept: 'application/json' },
            })
            const data = await response.json()

            if (!response.ok) throw new Error(data.message || 'Ringkasan area tidak dapat dimuat.')

            const counts = data.severity_counts
            const latest = data.latest_reports.map(report => `${report.title} · ${report.status}`).join(' | ')
            output.textContent = `${data.area}: ${data.active_count} laporan aktif. Ringan ${counts.ringan}, sedang ${counts.sedang}, berat ${counts.berat}.${latest ? ` Terbaru: ${latest}` : ''}`
        } catch (error) {
            output.textContent = error instanceof Error ? error.message : 'Ringkasan area tidak dapat dimuat.'
        }
    })
})
