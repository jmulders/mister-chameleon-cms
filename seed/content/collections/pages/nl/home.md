---
id: home
blueprint: pages
site: nl
title: Home
template: marketing_page
uri: /
seo_description: 'Neutrale startpagina — vervang deze placeholder-tekst door je eigen content.'
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
    title: 'Jouw belangrijkste boodschap hier'
    subtitle: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
    tag: 'Introductie'
    ctas:
      - label: 'Primaire actie'
        href: '#'
      - label: 'Meer informatie'
        href: '#'
proof_variants:
  - type: proof_variant
    key: proof_default
    is_active: true
    title: 'Social proof'
    items:
      - title: 'Kerncijfer één'
        text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
      - title: 'Kerncijfer twee'
        text: 'Sed do eiusmod tempor incididunt ut labore et dolore.'
      - title: 'Kerncijfer drie'
        text: 'Ut enim ad minim veniam, quis nostrud exercitation.'
feature_variants:
  - type: feature_variant
    key: feature_default
    is_active: true
    layout_variant: feature_grid
    title: 'Belangrijkste functies'
    subtitle: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.'
    items:
      - title: 'Functie één'
        body: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
      - title: 'Functie twee'
        body: 'Sed do eiusmod tempor incididunt ut labore et dolore magna.'
      - title: 'Functie drie'
        body: 'Ut enim ad minim veniam, quis nostrud exercitation ullamco.'
cta_variants:
  - type: cta_variant
    key: cta_default
    is_active: true
    title: 'Een duidelijke call-to-action'
    text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt.'
    cta_label: 'Primaire actie'
    cta_href: '#'
conversion_variants:
  - type: conversion_variant
    key: conversion_default
    is_active: true
    layout_variant: default
    title: 'Sluit af met een laatste duw'
    text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.'
    ctas:
      - label: 'Account aanmaken'
        href: '#'
      - label: 'Neem contact op'
        href: '#'
robots_noindex: false
robots_nofollow: false
---
