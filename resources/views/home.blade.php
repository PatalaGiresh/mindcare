@extends('layouts.guest')
@section('title', __('mindcare.welcome'))
@section('meta_description', __('mindcare.hero_subtitle'))

@section('content')
{{-- Hero --}}
<section class="hero">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;">
            <div class="hero-content animate-fade-in-up">
                <div class="hero-badge">{{ __('mindcare.hero_badge') }}</div>
                <h1>{{ __('mindcare.hero_title') }}</h1>
                <p>{{ __('mindcare.hero_p') }}</p>
                <div class="hero-actions">
                    <a href="{{ route('register') }}" class="btn btn-lg" style="background:#fff;color:var(--primary);font-weight:700;">{{ __('mindcare.get_started') }}</a>
                    <a href="{{ route('therapists.index') }}" class="btn btn-lg btn-outline" style="border-color:rgba(255,255,255,0.5);color:#fff;">{{ __('mindcare.find_therapist') }}</a>
                </div>
                <div class="hero-stats">
                    <div>
                        <div class="hero-stat-number">{{ number_format($stats['therapists']) }}+</div>
                        <div class="hero-stat-label">{{ __('mindcare.hero_stats_therapists') }}</div>
                    </div>
                    <div>
                        <div class="hero-stat-number">{{ number_format($stats['patients']) }}+</div>
                        <div class="hero-stat-label">{{ __('mindcare.hero_stats_patients') }}</div>
                    </div>
                    <div>
                        <div class="hero-stat-number">{{ number_format($stats['sessions']) }}+</div>
                        <div class="hero-stat-label">{{ __('mindcare.hero_stats_sessions') }}</div>
                    </div>
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:16px;" class="animate-fade-in">
                {{-- Feature cards floating on hero --}}
                <div style="background:rgba(255,255,255,0.12);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.2);border-radius:var(--radius-md);padding:20px;">
                    <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2" style="margin-bottom:10px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <div style="color:#fff;font-weight:600;margin-bottom:6px;">{{ __('mindcare.feat_mood_title') }}</div>
                    <div style="color:rgba(255,255,255,0.75);font-size:0.875rem;">{{ __('mindcare.feat_mood_desc') }}</div>
                </div>
                <div style="background:rgba(255,255,255,0.12);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.2);border-radius:var(--radius-md);padding:20px;">
                    <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2" style="margin-bottom:10px"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <div style="color:#fff;font-weight:600;margin-bottom:6px;">{{ __('mindcare.feat_expert_title') }}</div>
                    <div style="color:rgba(255,255,255,0.75);font-size:0.875rem;">{{ __('mindcare.feat_expert_desc') }}</div>
                </div>
                <div style="background:rgba(255,255,255,0.12);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.2);border-radius:var(--radius-md);padding:20px;">
                    <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2" style="margin-bottom:10px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <div style="color:#fff;font-weight:600;margin-bottom:6px;">{{ __('mindcare.feat_privacy_title') }}</div>
                    <div style="color:rgba(255,255,255,0.75);font-size:0.875rem;">{{ __('mindcare.feat_privacy_desc') }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- How it works --}}
<section class="section" style="background:var(--card);">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">{{ __('mindcare.how_tag') }}</div>
            <h2>{{ __('mindcare.how_title') }}</h2>
            <p>{{ __('mindcare.how_desc') }}</p>
        </div>
        <div class="grid-3">
            @foreach([
                ['step'=>'01','title'=>__('mindcare.how_step1_title'),'desc'=>__('mindcare.how_step1_desc')],
                ['step'=>'02','title'=>__('mindcare.how_step2_title'),'desc'=>__('mindcare.how_step2_desc')],
                ['step'=>'03','title'=>__('mindcare.how_step3_title'),'desc'=>__('mindcare.how_step3_desc')],
            ] as $step)
            <div style="text-align:center;padding:32px 24px;">
                <div style="width:56px;height:56px;border-radius:50%;background:var(--primary);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:1.2rem;font-weight:700;margin-bottom:16px;">{{ $step['step'] }}</div>
                <h3 style="font-size:1.1rem;margin-bottom:10px;">{{ $step['title'] }}</h3>
                <p style="color:var(--text-muted);font-size:0.875rem;line-height:1.65;">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Featured Therapists --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">{{ __('mindcare.therapist_tag') }}</div>
            <h2>{{ __('mindcare.therapist_title') }}</h2>
            <p>{{ __('mindcare.therapist_desc') }}</p>
        </div>
        <div class="grid-3">
            @foreach($therapists as $therapist)
            <div class="therapist-card animate-fade-in-up">
                <div class="d-flex align-center gap-16 mb-16">
                    <div class="therapist-avatar">{{ strtoupper(substr($therapist->user->name, 0, 1)) }}</div>
                    <div>
                        <div style="font-weight:700;font-size:0.95rem;color:var(--text-primary);">{{ $therapist->user->name }}</div>
                        <div class="therapist-specialty mt-4">{{ $therapist->specialty }}</div>
                    </div>
                </div>
                <div class="d-flex align-center gap-12 mb-12">
                    <span class="rating-stars">★ {{ number_format($therapist->rating, 1) }}</span>
                    <span style="font-size:0.8rem;color:var(--text-muted);">{{ $therapist->experience_years }} yrs exp</span>
                    <span style="font-size:0.8rem;color:var(--text-muted);">{{ $therapist->total_sessions }} sessions</span>
                </div>
                <p style="font-size:0.875rem;color:var(--text-muted);line-height:1.6;margin-bottom:18px;">{{ Str::limit($therapist->bio, 100) }}</p>
                <div class="d-flex justify-between align-center">
                    <span style="font-weight:700;color:var(--primary);">₹{{ number_format($therapist->hourly_rate) }}/hr</span>
                    <a href="{{ route('therapists.show', $therapist) }}" class="btn btn-primary btn-sm">{{ __('mindcare.view_profile') }}</a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-32">
            <a href="{{ route('therapists.index') }}" class="btn btn-outline btn-lg">{{ __('mindcare.view_all_therapists') }} →</a>
        </div>
    </div>
</section>

{{-- Mental Health Features --}}
<section class="section" style="background:linear-gradient(135deg,#1E4D4D,#2D6A6A);color:#fff;">
    <div class="container">
        <div class="section-header">
            <div class="section-tag" style="background:rgba(255,255,255,0.15);color:#fff;">{{ __('mindcare.why_tag') }}</div>
            <h2 style="color:#fff;">{{ __('mindcare.why_title') }}</h2>
            <p style="color:rgba(255,255,255,0.75);">{{ __('mindcare.why_desc') }}</p>
        </div>
        <div class="grid-4">
            @foreach([
                ['title'=>__('mindcare.feature_mood_analytics'),'desc'=>__('mindcare.feature_mood_analytics_desc')],
                ['title'=>__('mindcare.feature_session_reminders'),'desc'=>__('mindcare.feature_session_reminders_desc')],
                ['title'=>__('mindcare.feature_secure_messaging'),'desc'=>__('mindcare.feature_secure_messaging_desc')],
                ['title'=>__('mindcare.feature_resource_library'),'desc'=>__('mindcare.feature_resource_library_desc')],
                ['title'=>__('mindcare.feature_privacy_first'),'desc'=>__('mindcare.feature_privacy_first_desc')],
                ['title'=>__('mindcare.feature_multilingual'),'desc'=>__('mindcare.feature_multilingual_desc')],
                ['title'=>__('mindcare.feature_easy_payments'),'desc'=>__('mindcare.feature_easy_payments_desc')],
                ['title'=>__('mindcare.feature_verified_experts'),'desc'=>__('mindcare.feature_verified_experts_desc')],
            ] as $feature)
            <div style="padding:24px 16px;border-radius:var(--radius-md);background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);">
                <div style="width:36px;height:3px;background:var(--accent-light);border-radius:2px;margin-bottom:14px;"></div>
                <div style="color:#fff;font-weight:600;font-size:0.95rem;margin-bottom:8px;">{{ $feature['title'] }}</div>
                <div style="color:rgba(255,255,255,0.65);font-size:0.82rem;line-height:1.6;">{{ $feature['desc'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Latest Articles --}}
@if($articles->count() > 0)
<section class="section" style="background:var(--card);">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">{{ __('mindcare.knowledge_tag') }}</div>
            <h2>{{ __('mindcare.knowledge_title') }}</h2>
            <p>{{ __('mindcare.knowledge_desc') }}</p>
        </div>
        <div class="grid-3">
            @foreach($articles as $article)
            <div class="card">
                <div style="height:6px;background:linear-gradient(90deg,var(--primary),var(--accent));"></div>
                <div class="card-body">
                    <span class="badge badge-info mb-12">{{ $article->category }}</span>
                    <h3 style="font-size:1.05rem;margin-bottom:10px;line-height:1.35;">{{ $article->title }}</h3>
                    <p style="color:var(--text-muted);font-size:0.875rem;line-height:1.65;margin-bottom:16px;">{{ Str::limit($article->excerpt, 110) }}</p>
                    <div class="d-flex justify-between align-center">
                        <span style="font-size:0.78rem;color:var(--text-muted);">{{ $article->read_time ?? '5 min read' }}</span>
                        <a href="{{ route('resources.show', $article) }}" class="btn btn-ghost btn-sm">{{ __('mindcare.read_more') }}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-32">
            <a href="{{ route('resources.index') }}" class="btn btn-outline btn-lg">{{ __('mindcare.browse_articles') }} →</a>
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="section">
    <div class="container">
        <div style="background:linear-gradient(135deg,var(--accent),var(--primary));border-radius:var(--radius-xl);padding:64px;text-align:center;color:#fff;">
            <h2 style="color:#fff;font-size:2.2rem;margin-bottom:16px;">{{ __('mindcare.cta_title') }}</h2>
            <p style="color:rgba(255,255,255,0.85);font-size:1.05rem;margin-bottom:32px;max-width:500px;margin-left:auto;margin-right:auto;">{{ __('mindcare.cta_desc') }}</p>
            <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
                <a href="{{ route('register') }}" class="btn btn-lg" style="background:#fff;color:var(--primary);font-weight:700;">{{ __('mindcare.create_account') }}</a>
                <a href="{{ route('therapists.index') }}" class="btn btn-lg btn-outline" style="border-color:rgba(255,255,255,0.5);color:#fff;">{{ __('mindcare.browse_therapists') }}</a>
            </div>
        </div>
    </div>
</section>
@endsection
