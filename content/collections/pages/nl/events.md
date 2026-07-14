---
id: c2794fa8-845b-4e23-bdd1-13d837256f6b
blueprint: pages
site: nl
title: Evenementen
template: default
seo_description: 'Webinars, sessies en events van Mister Chameleon.'
meta_keywords:
  - events
  - evenementen
  - webinar
  - sessies
page_blocks:
  - type: text_section
    enabled: true
    variant: text_lead
    heading: Evenementen
    body: '<p>Webinars en sessies waarin we het platform laten zien, of waarin we met anderen bespreken wat er in B2B-personalisatie wel en niet werkt. Meestal kort, altijd met ruimte voor vragen.</p>'
  - type: collection_listing
    enabled: true
    collection: events
    variant: listing_cards
    sort_by: date
    sort_direction: asc
    limit: 12
  - type: cta_section
    enabled: true
    variant: cta_card
    heading: 'Liever een gesprek dan een zaal?'
    body: 'Een demo van 30 minuten, één op één, met uw eigen site als voorbeeld.'
    primary_cta:
      label: 'Demo boeken'
      href: /book-demo
    secondary_cta:
      label: 'Bekijk de prijzen'
      href: /pricing
---
