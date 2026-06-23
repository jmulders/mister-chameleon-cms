---
id: showcase
blueprint: pages
site: nl
title: 'Componenten showcase'
template: marketing_page
uri: /showcase
seo_description: 'Overzicht van alle beschikbare content-blokken met neutrale placeholder-inhoud.'
page_blocks:
  - id: sc-text
    type: text_section
    heading: 'Tekstsectie'
    body: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.'
  - id: sc-media
    type: image
    eyebrow: 'Tekst + media'
    heading: 'Beeld naast tekst'
    body: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
    media_type: image
    image:
      - placeholder-wide-1.jpg
    ctas:
      - label: 'Primaire actie'
        href: '#'
  - id: sc-features
    type: feature_grid
    heading: 'Functies in een grid'
    items:
      - type: feature
        icon: 'sparkles'
        title: 'Functie één'
        body: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
      - type: feature
        icon: 'bolt'
        title: 'Functie twee'
        body: 'Sed do eiusmod tempor incididunt ut labore et dolore.'
      - type: feature
        icon: 'shield'
        title: 'Functie drie'
        body: 'Ut enim ad minim veniam, quis nostrud exercitation.'
  - id: sc-stats
    type: stats
    heading: 'Kerncijfers'
    items:
      - prefix: ''
        value: '100'
        suffix: '+'
        label: 'Lorem ipsum dolor'
      - prefix: ''
        value: '3'
        suffix: '×'
        label: 'Consectetur adipiscing'
      - prefix: ''
        value: '24'
        suffix: '/7'
        label: 'Sed do eiusmod tempor'
  - id: sc-logos
    type: logo_strip
    heading: 'Vertrouwd door'
    logos:
      - name: 'Logo één'
        image:
          - placeholder-logo-1.jpg
        url: '#'
      - name: 'Logo twee'
        image:
          - placeholder-logo-2.jpg
        url: '#'
      - name: 'Logo drie'
        image:
          - placeholder-logo-3.jpg
        url: '#'
      - name: 'Logo vier'
        image:
          - placeholder-logo-4.jpg
        url: '#'
  - id: sc-testimonials
    type: testimonial_section
    heading: 'Wat klanten zeggen'
    items:
      - type: testimonial
        quote: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.'
        author: 'Voornaam Achternaam'
        role: 'Functietitel'
        company: 'Bedrijfsnaam'
        avatar:
          - placeholder-avatar-1.jpg
      - type: testimonial
        quote: 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.'
        author: 'Voornaam Achternaam'
        role: 'Functietitel'
        company: 'Bedrijfsnaam'
        avatar:
          - placeholder-avatar-2.jpg
  - id: sc-video
    type: video
    video_source: youtube
    video_id: 'ScMzIvxBSi4'
    video_autoplay: false
    video_loop: false
    caption: 'Lorem ipsum — vervang door je eigen video.'
  - id: sc-quote
    type: quote_block
    quote: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
    author: 'Voornaam Achternaam'
    role: 'Functietitel'
    avatar:
      - placeholder-avatar-3.jpg
  - id: sc-faq
    type: faq_section
    heading: 'Veelgestelde vragen'
    source_mode: manual
    items:
      - question: 'Eerste vraag als placeholder?'
        answer: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.'
      - question: 'Tweede vraag als placeholder?'
        answer: 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.'
  - id: sc-cta
    type: cta_section
    heading: 'Een duidelijke call-to-action'
    body: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.'
    primary_cta:
      - label: 'Primaire actie'
        href: '#'
    secondary_cta:
      - label: 'Secundaire actie'
        href: '#'
robots_noindex: true
robots_nofollow: false
---
