---
id: home
blueprint: pages
site: nl
title: Home
template: marketing_page
uri: /
seo_description: 'Real-time B2B website personalisation — no cookies, no manual segmenting.'
page_blocks:
  - id: ctx-hero
    type: context_slot
    slot_type: hero
    variant_key: hero_default
    is_active: true
    enabled: true
  - id: ctx-proof
    type: context_slot
    slot_type: proof
    variant_key: proof_default
    is_active: true
    enabled: true
  - id: ctx-feature
    type: context_slot
    slot_type: feature
    variant_key: feature_default
    is_active: true
    enabled: true
  - id: ctx-cta
    type: context_slot
    slot_type: cta
    variant_key: cta_default
    is_active: true
    enabled: true
  - id: ctx-conversion
    type: context_slot
    slot_type: conversion
    variant_key: conversion_default
    is_active: true
    enabled: true
hero_variants:
  - type: hero_variant
    key: hero_default
    is_active: true
    layout_variant: hero_default
    content_align: center
    title: 'Your website adapts to every visitor'
    subtitle: 'Real-time B2B personalisation — no cookies, no manual segmenting.'
    tag: 'Website personalisation'
    ctas:
      - label: 'Book a demo'
        href: /nl/book-demo
      - label: 'How it works'
        href: /features
proof_variants:
  - type: proof_variant
    key: proof_default
    is_active: true
    title: 'Trusted by B2B teams'
    items:
      - title: '+34% more leads'
        text: 'Average result after 90 days of personalisation.'
      - title: '3× higher engagement'
        text: 'Relevant content drives clicks, scrolls and contacts.'
      - title: 'No-code setup'
        text: 'One snippet in your CMS and you are live.'
feature_variants:
  - type: feature_variant
    key: feature_default
    is_active: true
    layout_variant: feature_grid
    title: 'Everything you need for smart personalisation'
    subtitle: 'From real-time segmentation to content management.'
    items:
      - title: 'Real-time segmentation'
        body: 'Classify every visitor instantly — no cookie wall.'
      - title: 'Visual variant editor'
        body: 'Configure hero, proof and CTA variants without code.'
      - title: 'Webhooks & API'
        body: 'Connect to your CRM, MAP or data layer.'
cta_variants:
  - type: cta_variant
    key: cta_default
    is_active: true
    title: 'See what personalisation can do for you'
    text: 'Book a free demo and watch your site become more relevant.'
    cta_label: 'Book a demo'
    cta_href: /nl/book-demo
conversion_variants:
  - type: conversion_variant
    key: conversion_default
    is_active: true
    layout_variant: default
    title: 'Start building today'
    text: 'Create your account and explore the platform — free.'
    ctas:
      - label: 'Create account'
        href: /signup
      - label: 'Book a demo'
        href: /nl/book-demo
robots_noindex: false
robots_nofollow: false
---
