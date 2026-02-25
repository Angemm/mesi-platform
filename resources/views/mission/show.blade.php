@extends('layouts.app')
@section('title', $mission->nom . ' — Missions M.E.SI')

@section('content')

<div style="background:linear-gradient(135deg,var(--navy),#1a3a6e);padding:80px 0 60px;">
    <div class="container">
        <nav style="font-size:0.82rem;color:rgba(255,255,255,0.5);margin-bottom:16px;">
            <a href="{{ route('home') }}" style="color:rgba(255,255,255,0.5)">Accueil</a>
            <span style="margin:0 8px;">›</span>
            <a href="{{ route('missions.index') }}" style="color:rgba(255,255,255,0.5)">Missions</a>
            <span style="margin:0 8px;">›</span>
            <span style="color:var(--gold)">{{ $mission->nom }}</span>
        </nav>
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;">
            <span style="background:rgba(232,176,75,0.2);border:1px solid rgba(232,176,75,0.4);color:var(--gold);padding:5px 14px;border-radius:100px;font-size:0.78rem;font-weight:700;text-transform:uppercase;">
                <i class="fas fa-map-marker-alt"></i> {{ $mission->pays ?? $mission->region }}
            </span>
            @if($mission->actif)
            <span style="background:rgba(26,122,60,0.2);border:1px solid rgba(26,122,60,0.4);color:#4ade80;padding:5px 14px;border-radius:100px;font-size:0.78rem;font-weight:700;text-transform:uppercase;">
                <i class="fas fa-circle" style="font-size:0.5rem"></i> Active
            </span>
            @endif
        </div>
        <h1 style="font-family:'Playfair Display',serif;font-size:2.5rem;color:white;margin-bottom:12px;">{{ $mission->nom }}</h1>
        @if($mission->responsable)
        <p style="color:rgba(255,255,255,0.65);"><i class="fas fa-user" style="color:var(--gold)"></i> Responsable : {{ $mission->responsable }}</p>
        @endif
    </div>
</div>

<section class="section">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 350px;gap:48px;align-items:start;">

            <div>
                @if($mission->image)
                <img src="{{ asset('storage/'.$mission->image) }}" style="width:100%;height:380px;object-fit:cover;border-radius:16px;margin-bottom:32px;" alt="{{ $mission->nom }}">
                @endif

                <div style="font-size:1rem;color:var(--text);line-height:1.9;">
                    {!! nl2br(e($mission->description)) !!}
                </div>
            </div>

            <!-- Panneau de soutien -->
            <div>
                @if($mission->objectif_don > 0)
                <div class="admin-card" style="margin-bottom:20px;">
                    <div class="admin-card-header">
                        <h3><i class="fas fa-heart" style="color:var(--red-live)"></i> Soutenir cette Mission</h3>
                    </div>
                    <div class="admin-card-body">
                        @php $pct = $mission->objectif_don > 0 ? min(100, round(($mission->dons_recus / $mission->objectif_don) * 100)) : 0; @endphp
                        <div style="margin-bottom:16px;">
                            <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                                <span style="font-size:0.82rem;color:var(--text-muted)">Progression</span>
                                <strong style="color:var(--gold-dark)">{{ $pct }}%</strong>
                            </div>
                            <div style="height:8px;background:#e8e8e8;border-radius:8px;overflow:hidden;">
                                <div class="mission-progress-fill" data-width="{{ $pct }}" style="height:100%;background:linear-gradient(90deg,var(--gold),var(--gold-dark));border-radius:8px;"></div>
                            </div>
                            <div style="display:flex;justify-content:space-between;margin-top:8px;">
                                <span style="font-size:0.8rem;color:var(--text-muted)">{{ number_format($mission->dons_recus) }} FCFA collectés</span>
                                <span style="font-size:0.8rem;color:var(--text-muted)">Objectif : {{ number_format($mission->objectif_don) }} FCFA</span>
                            </div>
                        </div>
                        <a href="{{ route('don') }}?mission={{ $mission->id }}" class="btn-submit" style="font-size:0.9rem;padding:12px;">
                            <i class="fas fa-heart"></i> Faire un Don pour cette Mission
                        </a>
                    </div>
                </div>
                @endif

                <div class="admin-card">
                    <div class="admin-card-header">
                        <h3><i class="fas fa-info-circle" style="color:var(--gold)"></i> Informations</h3>
                    </div>
                    <div class="admin-card-body" style="display:flex;flex-direction:column;gap:14px;">
                        @if($mission->pays)
                        <div style="display:flex;gap:10px;align-items:flex-start;">
                            <i class="fas fa-map-marker-alt" style="color:var(--gold);margin-top:2px;"></i>
                            <div><strong style="font-size:0.82rem;color:var(--navy);display:block;">Pays / Région</strong>
                            <span style="font-size:0.85rem;color:var(--text-muted)">{{ $mission->pays }}{{ $mission->region ? ' — '.$mission->region : '' }}</span></div>
                        </div>
                        @endif
                        @if($mission->date_debut)
                        <div style="display:flex;gap:10px;align-items:flex-start;">
                            <i class="fas fa-calendar" style="color:var(--gold);margin-top:2px;"></i>
                            <div><strong style="font-size:0.82rem;color:var(--navy);display:block;">Date de début</strong>
                            <span style="font-size:0.85rem;color:var(--text-muted)">{{ $mission->date_debut->isoFormat('D MMMM YYYY') }}</span></div>
                        </div>
                        @endif
                        @if($mission->responsable)
                        <div style="display:flex;gap:10px;align-items:flex-start;">
                            <i class="fas fa-user" style="color:var(--gold);margin-top:2px;"></i>
                            <div><strong style="font-size:0.82rem;color:var(--navy);display:block;">Responsable</strong>
                            <span style="font-size:0.85rem;color:var(--text-muted)">{{ $mission->responsable }}</span></div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
