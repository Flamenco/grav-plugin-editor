---

title: Editor Actions
template: editor-empty

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

{{ process_file_action() | raw }}