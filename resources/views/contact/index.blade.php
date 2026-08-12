@extends('layouts.app')

@section('title', 'Hubungi Kami - DJM Property')
@section('meta_description', 'Hubungi DJM Property untuk pertanyaan, konsultasi, atau bantuan terkait layanan properti kami.')

@push('scripts')
<style>


    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 60px;
        align-items: start;
    }

    .contact-info-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .contact-info-item {
        display: flex;
        align-items: center;
        gap: 18px;
        background: white;
        border: 1px solid var(--color-border);
        border-radius: var(--border-radius-lg);
        padding: 20px 24px;
        text-decoration: none;
        box-shadow: var(--shadow-sm);
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    }

    .contact-info-item:hover {
        transform: translateY(-3px);
        border-color: var(--color-primary);
        box-shadow: var(--shadow);
    }

    .info-icon {
        width: 50px;
        height: 50px;
        background: rgba(26, 92, 58, 0.1);
        color: var(--color-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
        transition: background 0.3s ease, color 0.3s ease;
    }

    .contact-info-item:hover .info-icon {
        background: var(--color-primary);
        color: white;
    }

    .info-content {
        flex: 1;
        min-width: 0;
    }

    .info-content h4 {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        margin-bottom: 4px;
        color: var(--color-text-muted);
    }

    .info-content p {
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--color-text-main);
        line-height: 1.4;
        margin: 0;
    }

    .info-arrow {
        color: var(--color-text-muted);
        font-size: 1.1rem;
        flex-shrink: 0;
        transition: color 0.3s ease, transform 0.3s ease;
    }

    .contact-info-item:hover .info-arrow {
        color: var(--color-primary);
        transform: translate(2px, -2px);
    }

    .contact-form-card {
        background: white;
        padding: 40px;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow);
        border: 1px solid var(--color-border);
    }

    .contact-form-card h2 {
        font-size: 2rem;
        margin-bottom: 10px;
        color: var(--color-text-main);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .contact-form textarea {
        resize: vertical;
        min-height: 150px;
    }

    @media (max-width: 991px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 767px) {
        .form-row {
            grid-template-columns: 1fr;
        }
        .contact-form-card {
            padding: 30px 25px;
        }
        .contact-form-card h2 {
            font-size: 1.6rem;
        }
        .contact-info-item {
            padding: 16px 18px;
            gap: 14px;
        }
        .info-icon {
            width: 42px;
            height: 42px;
            font-size: 1.1rem;
        }
    }

    @media (max-width: 480px) {
        .contact-form-card {
            padding: 25px 20px;
        }
        .contact-form-card h2 {
            font-size: 1.4rem;
        }
        .contact-info-item {
            padding: 14px 16px;
        }
        .info-content p {
            font-size: 0.95rem;
        }
    }
</style>
@endpush

@section('content')
    <div class="page-header">
        <div class="container" style="max-width: 800px;">
            <h1 class="page-title">Hubungi Kami</h1>
            <p style="color: var(--color-text-muted); font-size: 1.125rem;">
                Punya pertanyaan atau butuh konsultasi properti? Jangan ragu untuk menghubungi tim ahli kami. Kami siap membantu Anda.
            </p>
        </div>
    </div>

    <div class="container" style="margin-bottom: 80px;">
        <div class="contact-grid">
            
            <!-- Contact Info -->
            <div>
                @php
                    $contactAddress = $settings['contact_address'] ?? 'Jl. Kaliurang KM 7, Sleman, Yogyakarta';
                    $contactPhone = $settings['contact_phone'] ?? '+62 274 123456';
                    $contactWhatsapp = $settings['contact_whatsapp'] ?? '+62 812 3456 7890';
                    $contactEmail = $settings['contact_email'] ?? 'info@djmproperty.id';
                    $waNumber = preg_replace('/[^0-9]/', '', $contactWhatsapp);
                @endphp

                <h3 style="font-size: 1.75rem; margin-bottom: 30px;">Informasi Kontak</h3>

                <div class="contact-info-list">
                    <a href="mailto:{{ $contactEmail }}" class="contact-info-item">
                        <div class="info-icon"><i class="fa-solid fa-envelope"></i></div>
                        <div class="info-content">
                            <h4>Email</h4>
                            <p>{{ $contactEmail }}</p>
                        </div>
                        <span class="info-arrow"><i class="fa-solid fa-arrow-up-right-from-square"></i></span>
                    </a>

                    <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener" class="contact-info-item">
                        <div class="info-icon"><i class="fa-brands fa-whatsapp"></i></div>
                        <div class="info-content">
                            <h4>WhatsApp</h4>
                            <p>{{ $contactWhatsapp }}</p>
                        </div>
                        <span class="info-arrow"><i class="fa-solid fa-arrow-up-right-from-square"></i></span>
                    </a>

                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($contactAddress) }}" target="_blank" rel="noopener" class="contact-info-item">
                        <div class="info-icon"><i class="fa-solid fa-location-dot"></i></div>
                        <div class="info-content">
                            <h4>Lokasi</h4>
                            <p>{{ $contactAddress }}</p>
                        </div>
                        <span class="info-arrow"><i class="fa-solid fa-arrow-up-right-from-square"></i></span>
                    </a>

                    <a href="tel:{{ $contactPhone }}" class="contact-info-item">
                        <div class="info-icon"><i class="fa-solid fa-phone"></i></div>
                        <div class="info-content">
                            <h4>Telepon</h4>
                            <p>{{ $contactPhone }}</p>
                        </div>
                        <span class="info-arrow"><i class="fa-solid fa-arrow-up-right-from-square"></i></span>
                    </a>
                </div>

                <div style="margin-top: 40px;">
                    <h4 style="font-size: 1.1rem; margin-bottom: 15px; color: var(--color-text-main);">Ikuti Kami</h4>
                    <div style="display: flex; gap: 15px;">
                        <a href="#" style="color: var(--color-primary); font-size: 1.5rem; opacity: 0.8; transition: opacity 0.3s;"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#" style="color: var(--color-primary); font-size: 1.5rem; opacity: 0.8; transition: opacity 0.3s;"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" style="color: var(--color-primary); font-size: 1.5rem; opacity: 0.8; transition: opacity 0.3s;"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
            </div>

            <!-- Google Maps -->
            <div class="contact-form-card">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d988.2745163227136!2d110.40420506953696!3d-7.779426170752717!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a5900741d07fd%3A0x147ef590bcd70514!2sKOS%20PUTRI%20BU%20NUR!5e0!3m2!1sid!2sid!4v1786522666324!5m2!1sid!2sid"
                    style="border:0; width: 100%; min-height: 450px; border-radius: var(--border-radius-lg);"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="strict-origin-when-cross-origin">
                </iframe>
            </div>
        </div>
    </div>
@endsection
