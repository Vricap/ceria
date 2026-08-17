@extends('layouts.app')

@section('title', 'Detail Portfolio | DJM Desty Jaya Mandiri')
@section('meta_description', 'Detail portfolio pekerjaan DJM Desty Jaya Mandiri.')
@section('canonical', url('/portfolio/' . $slug))

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@@type": "ListItem",
      "position": 1,
      "name": "Beranda",
      "item": "{{ url('/') }}"
    },
    {
      "@@type": "ListItem",
      "position": 2,
      "name": "Portfolio",
      "item": "{{ route('portfolio.index') }}"
    }
  ]
}
</script>
@endsection

@section('content')
    <div class="page-header">
        <div class="container" style="max-width: 800px;">
            <h1 class="page-title">Detail Portfolio</h1>
            <p style="color: var(--color-text-muted); font-size: 1.125rem;">
                Informasi lengkap mengenai proyek yang dikerjakan DJM.
            </p>
        </div>
    </div>

    <div class="container" style="max-width: 900px; margin-bottom: 80px;">
        <div style="text-align: center; padding: 60px;">
            <i class="fa-solid fa-folder-open" style="font-size: 3rem; color: var(--color-border); margin-bottom: 20px; display: block;"></i>
            <p style="color: var(--color-text-muted);">Detail portfolio akan tersedia segera.</p>
            <a href="{{ route('portfolio.index') }}" class="btn btn-primary" style="margin-top: 20px;">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Portfolio
            </a>
        </div>
    </div>
@endsection
