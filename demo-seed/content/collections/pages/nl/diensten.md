---
id: demo-diensten
blueprint: pages
site: nl
title: Diensten
template: marketing_page
uri: /diensten
seo_description: 'Wat Acme voor je kan doen: ontwerp, bouw en onderhoud van je website.'
page_blocks:
  - id: demo-diensten-intro
    type: text_section
    enabled: true
    heading: 'Wat we doen'
    body: 'We ontwerpen en bouwen websites, en houden ze daarna bij. Je kunt bij ons terecht voor het hele traject of voor een deel ervan.'
  - id: demo-diensten-grid
    type: feature_grid
    enabled: true
    heading: 'Onze diensten'
    items:
      - type: feature
        icon: pencil
        title: Ontwerp
        body: 'Een ontwerp dat past bij je huisstijl en werkt op elk scherm. We beginnen bij wat je bezoeker zoekt.'
      - type: feature
        icon: code
        title: Bouw
        body: 'We bouwen de site in een CMS dat je zelf kunt bedienen, met blokken die je onderling kunt schikken.'
      - type: feature
        icon: refresh
        title: Onderhoud
        body: 'Updates, back-ups en beveiliging regelen wij. Jij houdt je bezig met de inhoud.'
      - type: feature
        icon: users
        title: Begeleiding
        body: 'Een korte training zodat je redactie zelfstandig verder kan, en een aanspreekpunt als je vastloopt.'
  - id: demo-diensten-stappen
    type: process_steps
    enabled: true
    variant: default
    heading: 'Hoe we werken'
    steps:
      - type: step
        number: '1'
        title: Kennismaken
        body: 'We bespreken wat je wilt bereiken en voor wie de site bedoeld is.'
        duration: '1 gesprek'
      - type: step
        number: '2'
        title: Opzet
        body: 'Je krijgt een ontwerp van de belangrijkste pagina''s, zodat je ziet waar het heen gaat.'
        duration: '1 week'
      - type: step
        number: '3'
        title: Bouwen
        body: 'We zetten de site in elkaar en vullen die samen met jouw teksten en beeld.'
        duration: '2 weken'
      - type: step
        number: '4'
        title: Live
        body: 'De site gaat online en je redactie krijgt een korte training om zelf verder te kunnen.'
        duration: '1 dag'
  - id: demo-diensten-tekst
    type: rich_text
    enabled: true
    max_width: default
    body:
      - type: paragraph
        content:
          - type: text
            text: 'Vanaf het moment dat de site live staat beheer je hem zelf, met ons op de achtergrond. Loop je vast, dan is er altijd iemand bereikbaar.'
  - id: demo-diensten-cta
    type: cta_section
    enabled: true
    heading: 'Iets waar je aan denkt?'
    body: 'Laat het weten, dan kijken we vrijblijvend of we kunnen helpen.'
    primary_cta:
      - label: 'Neem contact op'
        href: /contact
robots_noindex: false
robots_nofollow: false
---
