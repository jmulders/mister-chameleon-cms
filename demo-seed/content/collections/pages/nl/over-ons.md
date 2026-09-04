---
id: demo-over-ons
blueprint: pages
site: nl
title: 'Over ons'
template: marketing_page
uri: /over-ons
seo_description: 'Wie er bij Acme werkt en waar we voor staan.'
page_blocks:
  - id: demo-over-intro
    type: text_section
    enabled: true
    heading: 'Wie we zijn'
    body: 'Acme is een klein team dat websites bouwt voor organisaties die hun eigen verhaal willen kunnen vertellen. We werken direct met je mee, zonder tussenlagen.'
  - id: demo-over-team
    type: team_section
    enabled: true
    variant: team_grid
    heading: 'Het team'
    intro: 'Je hebt bij ons met dezelfde mensen te maken, van eerste gesprek tot oplevering.'
    members:
      - name: 'Anna Meijer'
        role: Oprichter
        bio: 'Anna begon Acme met één doel: opdrachtgevers een site geven die ze zelf kunnen beheren.'
        image:
          - placeholder-avatar-1.jpg
      - name: 'Joost Bakker'
        role: Projectleider
        bio: 'Joost bewaakt de planning en is je eerste aanspreekpunt tijdens het traject.'
        image:
          - placeholder-avatar-2.jpg
      - name: 'Fatima el Amrani'
        role: Ontwerper
        bio: 'Fatima vertaalt wat je wilt uitstralen naar een ontwerp dat op elk scherm klopt.'
        image:
          - placeholder-avatar-3.jpg
  - id: demo-over-video
    type: video
    enabled: true
    title: 'Een kijkje bij Acme'
    video_source: youtube
    video_id: ScMzIvxBSi4
    video_autoplay: false
    video_loop: false
    caption: 'Vervang deze video door je eigen bedrijfsfilm.'
    variant: contained
  - id: demo-over-quote
    type: quote_block
    enabled: true
    variant: quote-card
    quote: 'Een website is pas af als de organisatie er zelf mee verder kan.'
    author: 'Anna Meijer'
    role: 'Oprichter van Acme'
    avatar:
      - placeholder-avatar-1.jpg
  - id: demo-over-tijdlijn
    type: timeline
    enabled: true
    variant: timeline_vertical
    heading: 'Ons verhaal'
    description: 'Van eenmanszaak naar een vast team van drie.'
    items:
      - type: item
        date: '2014'
        title: 'Acme begint'
        description: 'Anna start voor zichzelf, met één opdrachtgever en een laptop aan de keukentafel.'
      - type: item
        date: '2019'
        title: 'Het team groeit'
        description: 'Joost komt erbij om projecten te begeleiden, zodat opdrachtgevers één aanspreekpunt hebben.'
      - type: item
        date: '2023'
        title: 'Eigen ontwerpwerk'
        description: 'Met Fatima erbij doen we ontwerp en bouw volledig in eigen huis.'
  - id: demo-over-stats
    type: stats
    enabled: true
    heading: 'Acme in cijfers'
    items:
      - prefix: ''
        value: '120'
        suffix: '+'
        label: 'Opgeleverde websites'
      - prefix: ''
        value: '12'
        suffix: ' jaar'
        label: 'Ervaring in het vak'
      - prefix: ''
        value: '3'
        suffix: ''
        label: 'Vaste teamleden'
  - id: demo-over-testimonials
    type: testimonial_section
    enabled: true
    heading: 'Hoe het is om met ons te werken'
    items:
      - type: testimonial
        quote: 'Korte lijnen en duidelijke afspraken. We wisten elke week waar we stonden.'
        author: 'Miriam Kok'
        role: Directeur
        company: 'Veldhuis Advies'
        avatar:
          - placeholder-avatar-3.jpg
      - type: testimonial
        quote: 'Ze dachten mee over wat we níet moesten bouwen. Dat scheelde ons een hoop.'
        author: 'Tarik Yildiz'
        role: 'Hoofd Communicatie'
        company: 'Havenstad Groep'
        avatar:
          - placeholder-avatar-2.jpg
robots_noindex: false
robots_nofollow: false
---
