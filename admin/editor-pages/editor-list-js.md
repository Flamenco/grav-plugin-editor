---

title: Javascript Editor File List
cache:
    enabled: false
never_cache_twig: true
process:
    twig: true
    
access:
  admin.login: true
  admin.super: true

editable: false

---

{{ js_editor_directories() | raw }}