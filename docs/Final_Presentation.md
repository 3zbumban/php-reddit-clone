# Final Presentation 28.05.2022 [12:50 – 13:05 B0.07]

Simple Reddit Clone

- create threads, posts, comment and vote
- everybody can see content
- only logged in users can create content

![](logo.png)

## Agenda

- Readme
  - quickstart
  - architecture
  - db schema
- Demo
  - Signup
  - Create Thread
  - Chreate Post
  - Comment
  - Vote
  - Seccond account
  - Comment
  - Vote
  - Vote Again
  - Invalidate JWT
- backend
  - index.php
  - Router
  - Controller
  - Service
  - Models
  - JWT Auth
  - index.php -> `res.json();`
- eventually client
  - service
  - views

## Requirements

- [x] Stack: HTML, CSS, PHP, JS
- [x] No Web Frameworks but my own PHP
- [x] Database Persistence Layer: `mariadb`
  - `propel ORM`
- [x] Userinputs: requests with `JSON`
- [x] Architecture: `Router` -> `Controller` -> `Service` -> `Model`
- [x] Login/Signup: `JWT` Authentication
- [x] User Interface: `Vue.js` + my own `CSS`

---

- [x] JS for Async communication: `fetch()`
- [x] UI Usability: `loaders`, `alerts`, `routing`, `pathparams`
- [x] Setup with Docker containers and `docker compose`
- [x] SOLID
  - maintainable
  - reliabile
  - clear separation of concerns
  - extensible
  - layers