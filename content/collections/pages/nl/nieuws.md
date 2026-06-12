---
id: nieuws
blueprint: pages
site: nl
title: Nieuws
template: listing_page
seo_description: 'Lees het laatste nieuws en de nieuwste artikelen van Mister Chameleon.'
excerpt: 'Nieuws, artikelen en inzichten van Mister Chameleon over B2B-marketing en website personalisatie.'
page_blocks:
  - id: nieuws-hero
    type: context_slot
    slot_type: hero
    variant_key: hero_page_banner_awareness
    is_active: true
    enabled: true
  - id: nieuws-intro
    type: text_section
    enabled: true
    variant: text_single
    heading: 'Nieuws & artikelen'
    body: '<p>Ontdek de laatste artikelen, nieuws en inzichten van Mister Chameleon.</p>'
  - id: nieuws-grid
    type: collection_listing
    enabled: true
    collection: blog
    variant: listing_cards
    heading: 'Recente artikelen'
    sort_by: date
    sort_direction: desc
    limit: 12
---
