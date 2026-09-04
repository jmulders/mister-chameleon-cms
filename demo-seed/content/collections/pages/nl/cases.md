---
id: demo-cases
blueprint: pages
site: nl
title: Cases
template: marketing_page
uri: /cases
seo_description: 'Voorbeelden van websites die Acme heeft opgeleverd.'
page_blocks:
  - id: demo-cases-intro
    type: text_section
    enabled: true
    heading: 'Ons werk'
    body: 'Een greep uit de sites die we hebben opgeleverd, en wat ze de opdrachtgever hebben opgeleverd.'
  - id: demo-cases-listing
    type: collection_listing
    enabled: true
    heading: 'Recente projecten'
    intro: 'Klik door voor het hele verhaal achter elk project.'
    collection: case_studies
    variant: listing_cards
    sort_by: date
    sort_direction: desc
    limit: 6
  - id: demo-cases-slider
    type: listing
    enabled: true
    variant: listing_slider
    heading: 'Beeld uit recente projecten'
    media_items:
      - type: slide
        media_type: image
        image:
          - placeholder-wide-1.jpg
        alt: 'Voorbeeldafbeelding uit een project'
        caption: 'Vervang deze afbeeldingen door beeld uit je eigen werk.'
      - type: slide
        media_type: image
        image:
          - placeholder-wide-2.jpg
        alt: 'Tweede voorbeeldafbeelding'
        caption: 'Elke slide heeft een eigen bijschrift.'
  - id: demo-cases-gerelateerd
    type: related_content
    enabled: true
    heading: 'Meer lezen'
    source_mode: automatic
    collection: case_studies
    max_items: 3
  - id: demo-cases-cta
    type: cta_section
    enabled: true
    heading: 'Ook zoiets voor jouw organisatie?'
    body: 'We denken graag mee over wat er bij je past.'
    primary_cta:
      - label: 'Neem contact op'
        href: /contact
robots_noindex: false
robots_nofollow: false
---
