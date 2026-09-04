---
id: demo-prijzen
blueprint: pages
site: nl
title: Prijzen
template: marketing_page
uri: /prijzen
seo_description: 'Wat een website bij Acme kost: drie pakketten met een vaste prijs per maand.'
page_blocks:
  - id: demo-prijzen-intro
    type: text_section
    enabled: true
    heading: 'Een vaste prijs per maand'
    body: 'Geen verrassingen achteraf. Je kiest een pakket en weet daarmee wat de site kost, inclusief hosting en onderhoud.'
  - id: demo-prijzen-pakketten
    type: pricing_section
    enabled: true
    heading: Pakketten
    subheading: 'Kies wat past bij waar je nu staat. Je kunt per maand wisselen.'
    footnote: 'Alle bedragen zijn exclusief btw. Opzeggen kan maandelijks.'
    tiers:
      - id: demo-tier-start
        name: Start
        price: '€ 29'
        period: '/maand'
        description: 'Voor wie net begint.'
        features: "Tot 5 pagina's\nContactformulier\nHosting en back-ups\nSSL-certificaat"
        cta_label: 'Kies Start'
        cta_href: /contact
        highlighted: false
      - id: demo-tier-groei
        name: Groei
        price: '€ 79'
        period: '/maand'
        description: 'De meest gekozen optie.'
        features: "Onbeperkt pagina's\nNieuws- en blogoverzicht\nMeerdere formulieren\nHosting en back-ups\nVoorrang bij support"
        cta_label: 'Kies Groei'
        cta_href: /contact
        highlighted: true
        badge: 'Meest gekozen'
      - id: demo-tier-compleet
        name: Compleet
        price: '€ 149'
        period: '/maand'
        description: 'Alles inbegrepen, met begeleiding.'
        features: "Alles uit Groei\nVast aanspreekpunt\nTraining voor je redactie\nJaarlijkse doorlichting\nReactie binnen 4 uur"
        cta_label: 'Kies Compleet'
        cta_href: /contact
        highlighted: false
  - id: demo-prijzen-faq
    type: faq_section
    enabled: true
    heading: 'Vragen over de prijs'
    source_mode: manual
    items:
      - question: 'Zit hosting bij de prijs in?'
        answer: 'Ja. Hosting, updates, back-ups en beveiliging zitten in het maandbedrag.'
      - question: 'Kan ik later wisselen van pakket?'
        answer: 'Dat kan per maand. Je zit nergens langer aan vast dan een maand.'
      - question: 'Zijn er opstartkosten?'
        answer: 'Voor het ontwerp en de bouw rekenen we een eenmalig bedrag. Dat spreken we vooraf af.'
  - id: demo-prijzen-cta
    type: cta_section
    enabled: true
    heading: 'Niet zeker welk pakket past?'
    body: 'Vertel wat je nodig hebt, dan adviseren we vrijblijvend.'
    primary_cta:
      - label: 'Stel je vraag'
        href: /contact
robots_noindex: false
robots_nofollow: false
---
