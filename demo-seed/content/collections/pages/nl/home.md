---
id: demo-home
blueprint: pages
site: nl
title: Home
template: marketing_page
uri: /
seo_title: 'Acme — websites die je zelf beheert'
seo_description: 'Acme bouwt websites die je zelf kunt onderhouden. Voorbeeldsite met neutrale demo-content.'
page_blocks:
  - id: demo-home-hero
    type: context_slot
    slot_type: hero
    variant_key: hero_default
    is_active: true
    enabled: true
  - id: demo-home-features
    type: feature_grid
    enabled: true
    heading: 'Waarom Acme'
    items:
      - type: feature
        icon: bolt
        title: 'In een middag live'
        body: 'Kies een opzet, vul je eigen teksten in en zet de site online. Geen ontwikkeltraject van maanden.'
      - type: feature
        icon: sparkles
        title: 'Alles in één CMS'
        body: 'Pagina''s, blokken, formulieren en navigatie beheer je zelf. Wat je aanpast staat er meteen op.'
      - type: feature
        icon: shield
        title: 'Privacyvriendelijk'
        body: 'Geen externe trackers, geen cookiemuur vooraf. Alles draait op je eigen domein.'
      - type: feature
        icon: chart-line
        title: 'Groeit met je mee'
        body: 'Begin met een paar pagina''s en breid uit wanneer het nodig is. De structuur blijft gelijk.'
  - id: demo-home-stats
    type: stats
    enabled: true
    heading: 'In het kort'
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
        value: '4'
        suffix: ' weken'
        label: 'Gemiddelde doorlooptijd'
  - id: demo-home-logos
    type: logo_strip
    enabled: true
    heading: 'Onder andere voor'
    logos:
      - name: Noordwind
        image:
          - placeholder-logo-1.jpg
        url: '#'
      - name: 'Havenstad Groep'
        image:
          - placeholder-logo-2.jpg
        url: '#'
      - name: 'Veldhuis Advies'
        image:
          - placeholder-logo-3.jpg
        url: '#'
      - name: 'De Bakkerij'
        image:
          - placeholder-logo-4.jpg
        url: '#'
  - id: demo-home-testimonials
    type: testimonial_section
    enabled: true
    heading: 'Wat opdrachtgevers zeggen'
    items:
      - type: testimonial
        quote: 'We waren binnen een middag live. Twee weken later lag ons aantal aanvragen merkbaar hoger.'
        author: 'Sanne de Wit'
        role: Marketingmanager
        company: Noordwind
        avatar:
          - placeholder-avatar-1.jpg
      - type: testimonial
        quote: 'Onze redacteuren beheren alles zelf. Geen ticket meer nodig om een pagina aan te passen.'
        author: 'Tarik Yildiz'
        role: 'Hoofd Communicatie'
        company: 'Havenstad Groep'
        avatar:
          - placeholder-avatar-2.jpg
  - id: demo-home-faq
    type: faq_section
    enabled: true
    heading: 'Veelgestelde vragen'
    source_mode: manual
    items:
      - question: 'Hoe lang duurt het voordat we live zijn?'
        answer: 'Meestal een paar weken. De site staat er snel; de meeste tijd gaat naar teksten en beeld verzamelen.'
      - question: 'Kunnen we de site zelf aanpassen?'
        answer: 'Ja. Pagina''s, teksten, afbeeldingen en navigatie beheer je zelf in het CMS.'
  - id: demo-home-cta
    type: cta_section
    enabled: true
    heading: 'Benieuwd wat het voor jou kan betekenen?'
    body: 'Vertel kort waar je tegenaan loopt. We denken vrijblijvend met je mee.'
    primary_cta:
      - label: 'Neem contact op'
        href: /contact
    secondary_cta:
      - label: 'Bekijk de prijzen'
        href: /prijzen
  - id: demo-home-form
    type: form_section
    enabled: true
    variant: form_inline
    heading: 'Stel je vraag'
    subtitle: 'Vul je gegevens in, dan reageren we binnen één werkdag.'
    form:
      - contact
    submit_label: 'Verstuur mijn vraag'
    post_submit: message
    success_message: 'Bedankt voor je bericht. We nemen binnen één werkdag contact met je op.'
  - id: demo-home-media
    type: image
    enabled: true
    eyebrow: 'Zo werkt het'
    heading: 'Van eerste gesprek tot live'
    body: 'We beginnen met wat je wilt bereiken, kiezen daar de opzet bij en vullen die samen met jouw teksten. Daarna kun je zelf verder.'
    media_type: image
    image:
      - placeholder-wide-1.jpg
    ctas:
      - label: 'Bekijk onze diensten'
        href: /diensten
hero_variants:
  - type: hero_variant
    key: hero_default
    is_active: true
    layout_variant: hero_default
    content_align: center
    title: 'Een website die je zelf beheert'
    subtitle: 'Acme bouwt overzichtelijke websites die je daarna zonder ons kunt onderhouden. Snel live, makkelijk uit te breiden.'
    tag: Acme
    ctas:
      - label: 'Neem contact op'
        href: /contact
      - label: 'Bekijk ons werk'
        href: /cases
  - type: hero_variant
    key: hero_b2b
    is_active: true
    layout_variant: hero_default
    content_align: center
    title: 'Eén site, elke doelgroep het juiste verhaal'
    subtitle: 'Laat de introductie meebewegen met waar je bezoeker vandaan komt, zonder dat je meerdere sites hoeft te beheren.'
    tag: 'Voor organisaties'
    ctas:
      - label: 'Plan een gesprek'
        href: /contact
      - label: 'Lees de cases'
        href: /cases
proof_variants:
  - type: proof_variant
    key: proof_default
    is_active: true
    title: 'Waar opdrachtgevers op letten'
    items:
      - title: 'Zelf te beheren'
        text: 'Je hebt ons niet nodig voor een tekstwijziging.'
      - title: 'Snel opgeleverd'
        text: 'Gemiddeld vier weken van eerste gesprek tot live.'
      - title: 'Vaste prijs'
        text: 'Vooraf duidelijk wat het kost, ook daarna.'
feature_variants:
  - type: feature_variant
    key: feature_default
    is_active: true
    layout_variant: feature_grid
    title: 'Wat je krijgt'
    subtitle: 'Een site die past bij hoe jouw organisatie werkt.'
    items:
      - title: 'Eigen huisstijl'
        body: 'Kleuren, lettertype en logo van je eigen merk.'
      - title: 'Werkt op elk scherm'
        body: 'Van telefoon tot breedbeeld, zonder aparte mobiele site.'
      - title: 'Vindbaar'
        body: 'Nette structuur en snelle pagina''s, zodat zoekmachines je vinden.'
cta_variants:
  - type: cta_variant
    key: cta_default
    is_active: true
    title: 'Zullen we kennismaken?'
    text: 'Een gesprek van een half uur is vaak genoeg om te weten of het klikt.'
    cta_label: 'Neem contact op'
    cta_href: /contact
robots_noindex: false
robots_nofollow: false
---
