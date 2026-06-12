---
site: nl
id: 35af7068-65dc-4f55-b0b5-537b9f3930e4
blueprint: pages
title: Page
template: default
page_blocks:
  - id: ctx_hero
    type: context_slot
    slot_type: hero
    variant_key: hero_default
    is_active: true
  - id: ctx_cta
    type: context_slot
    slot_type: cta
    variant_key: cta_default
    is_active: true
  -
    type: feature_grid
    enabled: true
    variant: feature_grid_3up
    heading: 'Waarom kiezen voor ons'
    subtitle: 'De voordelen die het verschil maken'
    items:
      -
        id: pg_feat_zap
        type: feature
        icon: Zap
        title: 'Snel van start'
        body: 'Live in één middag — geen lange implementaties.'
      -
        id: pg_feat_shield
        type: feature
        icon: Shield
        title: Privacy-vriendelijk
        body: 'Geen cookies, geen toestemming nodig.'
      -
        id: pg_feat_trending
        type: feature
        icon: TrendingUp
        title: 'Meetbare resultaten'
        body: 'Gemiddeld 3× hogere conversie.'
      -
        id: pg_feat_settings
        type: feature
        icon: Settings
        title: 'Eenvoudig beheer'
        body: 'Content beheren in uw vertrouwde CMS.'
      -
        id: pg_feat_users
        type: feature
        icon: Users
        title: 'Persoonlijke aanpak'
        body: 'Elke bezoeker krijgt de meest relevante boodschap.'
      -
        id: pg_feat_bar
        type: feature
        icon: BarChart2
        title: 'Inzicht & rapportage'
        body: 'Realtime inzicht in prestaties per segment.'
  -
    type: cta_section
    enabled: true
    variant: cta_card
    heading: 'Klaar om te starten?'
    body: 'Sluit u aan bij honderden bedrijven die al personaliseren.'
    primary_cta:
      label: 'Gratis proberen'
      href: /contact
    secondary_cta:
      label: 'Demo aanvragen'
      href: /contact
---
