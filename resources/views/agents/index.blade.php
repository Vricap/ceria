@extends('layouts.app')

@section('title', 'Daftar Agen - DJM Property')
@section('meta_description', 'Temukan agen properti profesional dan berpengalaman dari DJM Property yang siap membantu Anda menemukan properti idaman.')

@push('scripts')
<style>

    
    .agent-card-large {
        background: white;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--color-border);
        padding: 30px;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .agent-card-large:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow);
        border-color: var(--color-primary);
    }
    
    .agent-photo-lg {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 20px;
        border: 4px solid var(--color-surface);
        transition: transform 0.3s ease;
    }
    
    .agent-card-large:hover .agent-photo-lg {
        transform: scale(1.05);
        border-color: var(--color-primary-light);
    }

    .agent-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--color-text-main);
        margin-bottom: 5px;
    }
    
    .agent-name a {
        color: inherit;
    }
    
    .agent-name a:hover {
        color: var(--color-primary);
    }

    .agent-title {
        color: var(--color-primary);
        font-weight: 600;
        margin-bottom: 15px;
        font-size: 0.95rem;
    }

    .agent-stats {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 20px;
        padding: 15px 0;
        border-top: 1px solid var(--color-border);
        border-bottom: 1px solid var(--color-border);
    }

    .stat-box {
        text-align: center;
    }

    .stat-value {
        display: block;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--color-text-main);
    }

    .stat-label {
        font-size: 0.8rem;
        color: var(--color-text-muted);
    }

    .agent-social {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: auto;
    }

    .social-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--color-surface);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-text-muted);
        transition: all 0.3s;
    }

    .social-icon:hover {
        background: var(--color-primary);
        color: white;
        transform: translateY(-2px);
    }

    @media (max-width: 991px) {
        .page-title {
            font-size: 2rem;
        }
        .agent-photo-lg {
            width: 120px;
            height: 120px;
        }
    }

    @media (max-width: 767px) {
        .page-header {
            padding: 30px 0;
            margin-bottom: 25px;
        }
        .page-title {
            font-size: 1.75rem;
        }
        .agent-card-large {
            padding: 25px 20px;
        }
        .agent-photo-lg {
            width: 110px;
            height: 110px;
        }
        .agent-name {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 480px) {
        .page-title {
            font-size: 1.5rem;
        }
        .agent-card-large {
            padding: 20px 15px;
        }
        .agent-photo-lg {
            width: 100px;
            height: 100px;
        }
    }
</style>
@endpush

@section('content')
    <div class="page-header">
        <div class="container" style="max-width: 800px;">
            <h1 class="page-title">Tim Agen Kami</h1>
            <p style="color: var(--color-text-muted); font-size: 1.125rem;">
                Temui para ahli properti kami yang siap membantu Anda mewujudkan impian memiliki properti idaman dengan layanan profesional dan terpercaya.
            </p>
        </div>
    </div>

    <div class="container" style="margin-bottom: 80px;">
        @if($agents->count() > 0)
            <div class="grid grid-cols-4">
                @foreach($agents as $agent)
                    <div class="agent-card-large">
                        <a href="{{ route('agents.show', $agent->slug) }}">
                            <img src="{{ $agent->photo_url }}" alt="{{ $agent->name }}" class="agent-photo-lg">
                        </a>
                        <h2 class="agent-name">
                            <a href="{{ route('agents.show', $agent->slug) }}">{{ $agent->name }}</a>
                        </h2>
                        <div class="agent-title">{{ $agent->title }}</div>
                        
                        <div style="color: var(--color-text-muted); font-size: 0.9rem; margin-bottom: 20px;">
                            Spesialisasi: {{ $agent->specialization }}
                        </div>
                        
                        <div class="agent-stats">
                            <div class="stat-box">
                                <span class="stat-value">{{ $agent->properties_count }}</span>
                                <span class="stat-label">Properti</span>
                            </div>
                            <div class="stat-box">
                                <span class="stat-value">{{ $agent->experience_years }}</span>
                                <span class="stat-label">Tahun Exp</span>
                            </div>
                        </div>
                        
                        <div class="agent-social">
                            @if($agent->whatsapp)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $agent->whatsapp) }}" target="_blank" class="social-icon" title="WhatsApp" style="color: #25D366;">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                            @endif
                            @if($agent->instagram)
                                <a href="{{ $agent->instagram }}" target="_blank" class="social-icon" title="Instagram" style="color: #E1306C;">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            @endif
                            @if($agent->email)
                                <a href="mailto:{{ $agent->email }}" class="social-icon" title="Email">
                                    <i class="fa-solid fa-envelope"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 40px; display: flex; justify-content: center;">
                {{ $agents->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div style="text-align: center; padding: 60px;">
                <p>Belum ada data agen.</p>
            </div>
        @endif
    </div>
@endsection
