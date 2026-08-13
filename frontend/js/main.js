/* DJM — Desty Jaya Mandiri | Static frontend logic */
(function () {
  "use strict";

  var C = DJM;

  /* ── Helpers ─────────────────────────────────────────────── */
  function $(sel, ctx) { return (ctx || document).querySelector(sel); }
  function $$(sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); }

  function param(name) {
    return new URLSearchParams(window.location.search).get(name);
  }

  var palettes = [
    "linear-gradient(135deg,#EAF7FB 0%,#C8E9F2 100%)",
    "linear-gradient(135deg,#E6F4EF 0%,#C9E8DC 100%)",
    "linear-gradient(135deg,#F1EBFA 0%,#DED0F0 100%)",
    "linear-gradient(135deg,#E4F5F7 0%,#C0E6ED 100%)",
  ];
  function phColor(i) { return palettes[i % palettes.length]; }

  function waLink(message) {
    return "https://wa.me/" + C.wa + "?text=" + encodeURIComponent(message || "");
  }

  function mediaPlaceholder(color, icon, label) {
    return (
      '<div class="card-media" style="background:' + color +
      '"><div class="ph-icon"><i class="' + icon + '"></i><span>' +
      (label || "") + "</span></div></div>"
    );
  }

  function statusBadge(status) {
    var map = {
      dijual: { cls: "badge-sale", text: "DIJUAL" },
      disewakan: { cls: "badge-rent", text: "DISEWAKAN" },
    };
    var b = map[status] || map.dijual;
    return '<span class="badge ' + b.cls + '">' + b.text + "</span>";
  }

  /* ── Shared: Header / Footer / WA float ──────────────────── */
  var NAV = [
    { href: "index.html", label: "Beranda", page: "home" },
    { href: "tentang.html", label: "Tentang Kami", page: "tentang" },
    { href: "layanan.html", label: "Layanan", page: "layanan" },
    { href: "properti.html", label: "Properti", page: "properti" },
    { href: "portofolio.html", label: "Portfolio", page: "portofolio" },
    { href: "kontak.html", label: "Kontak", page: "kontak" },
  ];

  function activePage() {
    var b = document.body.dataset.page || "";
    if (b === "layanan-detail") return "layanan";
    if (b === "properti-detail") return "properti";
    return b;
  }

  function buildHeader() {
    var current = activePage();

    var navHtml = NAV.map(function (n) {
      return '<a class="nav-link ' + (n.page === current ? "active" : "") +
        '" href="' + n.href + '">' + n.label + "</a>";
    }).join("");

    var mobileHtml = NAV.map(function (n) {
      return '<a class="' + (n.page === current ? "active" : "") +
        '" href="' + n.href + '">' + n.label + "</a>";
    }).join("");

    var waMsg = waLink("Halo DJM, saya ingin bertanya.");

    var el = document.createElement("header");
    el.className = "site-header";
    el.innerHTML =
      '<div class="container header-inner">' +
      '<a class="logo" href="index.html"><span class="logo-icon"><i class="fa-solid fa-building"></i></span><span>DJM</span></a>' +
      '<nav class="main-nav"><div class="nav-list">' + navHtml +
      '<a class="btn btn-wa btn-sm" href="' + waMsg + '" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>' +
      "</div></nav>" +
      '<div class="header-actions">' +
      '<a class="btn btn-wa btn-sm header-wa-mobile" href="' + waMsg + '" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i></a>' +
      '<button class="menu-toggle" aria-label="Menu" aria-expanded="false"><i class="fa-solid fa-bars"></i></button>' +
      "</div></div>" +
      '<nav class="mobile-nav" aria-label="Menu mobile">' + mobileHtml + "</nav>";

    document.body.insertBefore(el, document.body.firstChild);

    var btn = $(".menu-toggle");
    var nav = $(".mobile-nav");
    btn.addEventListener("click", function () {
      var open = nav.classList.toggle("open");
      btn.setAttribute("aria-expanded", open ? "true" : "false");
      btn.innerHTML = open ? '<i class="fa-solid fa-xmark"></i>' : '<i class="fa-solid fa-bars"></i>';
    });
    $$(".mobile-nav a").forEach(function (a) {
      a.addEventListener("click", function () {
        nav.classList.remove("open");
        btn.setAttribute("aria-expanded", "false");
        btn.innerHTML = '<i class="fa-solid fa-bars"></i>';
      });
    });
  }

  function buildFooter() {
    var el = $("#app-footer");
    if (!el) return;

    var navHtml = NAV.map(function (n) {
      return '<li><a href="' + n.href + '">' + n.label + "</a></li>";
    }).join("");

    var svcHtml = C.services.slice(0, 5).map(function (s) {
      return '<li><a href="layanan-detail.html?slug=' + s.slug + '">' + s.name + "</a></li>";
    }).join("");

    el.innerHTML =
      '<div class="footer-top container">' +
      '<div class="footer-brand">' +
      '<a class="logo" href="index.html"><span class="logo-icon"><i class="fa-solid fa-building"></i></span><span>DJM — Desty Jaya Mandiri</span></a>' +
      "<p>Perusahaan terpercaya di bidang perizinan, properti, dan konstruksi di " + C.area + ".</p>" +
      '<div class="footer-social">' +
      '<a href="' + C.facebook + '" title="Facebook" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>' +
      '<a href="' + C.instagram + '" title="Instagram" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>' +
      '<a href="' + waLink("Halo DJM!") + '" title="WhatsApp" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>' +
      "</div></div>" +
      '<div class="footer-col"><h4>Navigasi</h4><ul>' + navHtml + "</ul></div>" +
      '<div class="footer-col"><h4>Layanan Kami</h4><ul>' + svcHtml + "</ul></div>" +
      '<div class="footer-col"><h4>Hubungi Kami</h4><ul class="f-contact">' +
      '<li><i class="fa-solid fa-location-dot"></i><span>' + C.address + "</span></li>" +
      '<li><i class="fa-solid fa-phone"></i><a href="tel:' + C.phoneRaw + '">' + C.phone + "</a></li>" +
      '<li><i class="fa-brands fa-whatsapp"></i><a href="' + waLink("Halo DJM!") + '" target="_blank" rel="noopener">+' + C.wa + "</a></li>" +
      '<li><i class="fa-solid fa-envelope"></i><a href="mailto:' + C.email + '">' + C.email + "</a></li>" +
      '<li><i class="fa-solid fa-clock"></i><span>' + C.hours + "</span></li>" +
      "</ul></div></div>" +
      '<div class="footer-bottom container">' +
      "<p>&copy; " + new Date().getFullYear() + " DJM — Desty Jaya Mandiri. All rights reserved.</p>" +
      '<div class="fb-links"><a href="kontak.html">Kontak</a><a href="tentang.html">Tentang Kami</a></div>' +
      "</div>";
  }

  function buildWA() {
    var el = document.createElement("a");
    el.className = "wa-float";
    el.href = waLink("Halo DJM, saya ingin berkonsultasi.");
    el.target = "_blank";
    el.rel = "noopener";
    el.setAttribute("aria-label", "Chat WhatsApp DJM");
    el.innerHTML = '<i class="fa-brands fa-whatsapp"></i>';
    document.body.appendChild(el);
  }

  /* ── Render: Home ────────────────────────────────────────── */
  function renderHome() {
    var heroStats = $("#hero-stats");
    if (heroStats) {
      heroStats.innerHTML = C.stats.map(function (s) {
        return '<div class="hero-stat"><strong>' + s.value + "</strong><span>" + s.label + "</span></div>";
      }).join("");
    }

    var catGrid = $("#home-categories");
    if (catGrid) {
      catGrid.innerHTML =
        '<a class="cat-card" href="layanan.html"><div class="cat-icon"><i class="fa-solid fa-file-shield"></i></div>' +
        "<h3>Perizinan</h3><p>PBG/IMB, pengeringan lahan, dan pecah sertifikat.</p>" +
        '<span class="btn btn-outline btn-sm">Lihat Detail</span></a>' +
        '<a class="cat-card" href="properti.html"><div class="cat-icon"><i class="fa-solid fa-house-chimney"></i></div>' +
        "<h3>Property</h3><p>Katalog rumah, tanah, ruko, dan villa terpilih.</p>" +
        '<span class="btn btn-outline btn-sm">Lihat Detail</span></a>' +
        '<a class="cat-card" href="layanan.html"><div class="cat-icon"><i class="fa-solid fa-helmet-safety"></i></div>' +
        "<h3>Konstruksi</h3><p>Pembangunan, renovasi, dan jasa konstruksi.</p>" +
        '<span class="btn btn-outline btn-sm">Lihat Detail</span></a>';
    }

    var propGrid = $("#home-properties");
    if (propGrid) {
      propGrid.innerHTML = C.properties.filter(function (p) { return p.featured; })
        .slice(0, 3).map(propertyCard).join("");
    }

    var portGrid = $("#home-portfolios");
    if (portGrid) {
      portGrid.innerHTML = C.portfolios.slice(0, 3).map(portfolioCard).join("");
    }
  }

  /* ── Render: Services ────────────────────────────────────── */
  function serviceCard(s) {
    return (
      '<article class="card service-card">' +
      '<div class="card-body">' +
      '<span class="service-tag">' + C.categories[s.category] + "</span>" +
      '<div class="service-icon"><i class="' + s.icon + '"></i></div>' +
      "<h3>" + s.name + "</h3>" +
      '<p class="desc">' + s.short + "</p>" +
      '<div class="card-actions">' +
      '<a class="btn btn-outline" href="layanan-detail.html?slug=' + s.slug + '">Pelajari Lebih Lanjut</a>' +
      '<a class="btn btn-wa" target="_blank" rel="noopener" href="' +
      waLink("Halo DJM, saya ingin berkonsultasi mengenai layanan " + s.name + ".") +
      '"><i class="fa-brands fa-whatsapp"></i> Konsultasi</a>' +
      "</div></div></article>"
    );
  }

  function renderServices() {
    var list = $("#service-list");
    if (!list) return;

    var cats = Object.keys(C.categories);
    var html = "";
    cats.forEach(function (key) {
      var items = C.services.filter(function (s) { return s.category === key; });
      if (!items.length) return;
      var icon = key === "konstruksi" ? "fa-helmet-safety" : "fa-file-shield";
      html +=
        '<div class="cat-block">' +
        '<div class="section-head">' +
        '<i class="fa-solid ' + icon + '" style="font-size:1.8rem;color:var(--cyan);margin-bottom:10px;display:inline-block;"></i>' +
        '<h2 class="section-title">' + C.categories[key] + "</h2>" +
        '<p class="section-subtitle">' +
        (key === "perizinan"
          ? "Legalitas bangunan dan lahan yang diurus secara resmi dan tepat waktu."
          : "Tim konstruksi berpengalaman dari perencanaan hingga selesai.") +
        "</p></div>" +
        '<div class="grid grid-3">' +
        items.map(serviceCard).join("") +
        "</div></div>";
    });
    list.innerHTML = html;
  }

  function renderServiceDetail() {
    var slug = param("slug");
    var svc = C.services.filter(function (s) { return s.slug === slug; })[0];
    var mount = $("#service-detail");
    if (!mount) return;

    if (!svc) {
      mount.innerHTML =
        '<div class="notfound"><i class="fa-solid fa-file-circle-question"></i><h2>Layanan tidak ditemukan</h2>' +
        '<p>Layanan yang Anda cari tidak tersedia.</p><a class="btn btn-primary" href="layanan.html">Kembali ke Layanan</a></div>';
      document.title = "Layanan Tidak Ditemukan — DJM";
      return;
    }

    document.title = svc.name + " — DJM Desty Jaya Mandiri";
    var meta = document.querySelector('meta[name="description"]');
    if (meta) meta.setAttribute("content", svc.short);

    var block = function (icon, title, items, isUl) {
      var body = isUl
        ? "<ul>" + items.map(function (it) { return "<li>" + it + "</li>"; }).join("") + "</ul>"
        : items.map(function (it) { return "<p>" + it + "</p>"; }).join("");
      return '<div class="d-block"><h2><i class="fa-solid ' + icon + '"></i>' + title + "</h2>" + body + "</div>";
    };

    var related = C.services.filter(function (s) { return s.slug !== svc.slug; }).slice(0, 3).map(function (s) {
      return '<a class="cat-card" href="layanan-detail.html?slug=' + s.slug + '">' +
        '<div class="cat-icon"><i class="' + s.icon + '"></i></div>' +
        "<h3>" + s.name + "</h3>" +
        '<span class="btn btn-outline btn-sm">Lihat Detail</span></a>';
    }).join("");

    mount.innerHTML =
      '<div class="page-header"><div class="container">' +
      '<p class="breadcrumb"><a href="index.html">Beranda</a> / <a href="layanan.html">Layanan</a> / ' + svc.name + "</p>" +
      '<span class="service-tag">' + C.categories[svc.category] + "</span>" +
      "<h1>" + svc.name + "</h1>" +
      "<p>" + svc.short + "</p></div></div>" +
      '<div class="container">' +
      '<div class="wa-panel">' +
      "<h2>Konsultasikan kebutuhan " + svc.name + " Anda</h2>" +
      "<p>Tim DJM siap membantu — gratis dan tanpa komitmen.</p>" +
      '<a class="btn btn-white" target="_blank" rel="noopener" href="' +
      waLink("Halo DJM, saya ingin berkonsultasi mengenai layanan " + svc.name + ".") +
      '"><i class="fa-brands fa-whatsapp"></i> Konsultasikan via WhatsApp</a></div>' +
      block("fa-circle-info", "Tentang Layanan", svc.desc) +
      block("fa-list-check", "Ruang Lingkup", svc.scope, true) +
      block("fa-timeline", "Proses Layanan", svc.process, true) +
      '<div class="wa-panel" style="background:var(--accent)">' +
      "<h2>Butuh penjelasan lebih detail?</h2>" +
      "<p>Hubungi tim DJM melalui WhatsApp untuk informasi lengkap mengenai persyaratan dan estimasi.</p>" +
      '<a class="btn btn-white" target="_blank" rel="noopener" href="' +
      waLink("Halo DJM, saya ingin bertanya tentang " + svc.name + ".") +
      '"><i class="fa-brands fa-whatsapp"></i> Hubungi WhatsApp</a></div>' +
      "</div>" +
      '<section class="section section-bg-white"><div class="container">' +
      '<div class="section-head"><h2 class="section-title">Layanan Lainnya</h2></div>' +
      '<div class="related-grid">' + related + "</div></div></section>";
  }

  /* ── Render: Properties ──────────────────────────────────── */
  function propertyCard(p, i) {
    var specs =
      '<div class="specs">' +
      '<span><i class="fa-solid fa-ruler-combined"></i> LT ' + p.land + "</span>" +
      '<span><i class="fa-solid fa-vector-square"></i> LB ' + p.building + "</span>" +
      (p.bedrooms !== "-" ? '<span><i class="fa-solid fa-bed"></i> ' + p.bedrooms + " KT</span>" : "") +
      (p.bathrooms !== "-" ? '<span><i class="fa-solid fa-bath"></i> ' + p.bathrooms + " KM</span>" : "") +
      "</div>";

    return (
      '<article class="card property-card">' +
      mediaPlaceholder(phColor(i), "fa-solid fa-house-chimney", p.type) +
      '<div class="card-badges">' + statusBadge(p.status) +
      (p.featured ? '<span class="badge badge-featured">UNGGULAN</span>' : "") +
      "</div>" +
      '<div class="card-body">' +
      '<div class="price">' + p.price + "</div>" +
      "<h3><a href=\"properti-detail.html?slug=" + p.slug + '">' + p.title + "</a></h3>" +
      '<p class="location"><i class="fa-solid fa-location-dot"></i>' + p.location + "</p>" +
      specs +
      '<div class="card-actions">' +
      '<a class="btn btn-outline" href="properti-detail.html?slug=' + p.slug + '">Lihat Detail</a>' +
      '<a class="btn btn-wa" target="_blank" rel="noopener" href="' +
      waLink("Halo DJM, saya tertarik dengan properti " + p.title + " (" + p.price + "). Mohon info lebih lanjut.") +
      '"><i class="fa-brands fa-whatsapp"></i></a>' +
      "</div></div></article>"
    );
  }

  function renderProperties() {
    var list = $("#property-list");
    if (!list) return;

    var typeEl = $("#f-type"),
      statusEl = $("#f-status"),
      minEl = $("#f-min"),
      maxEl = $("#f-max");

    var state = { type: "", status: "", min: "", max: "" };

    // Isi opsi jenis properti sekali dari data
    var types = {};
    C.properties.forEach(function (p) { types[p.type] = true; });
    typeEl.innerHTML = '<option value="">Semua Jenis</option>' +
      Object.keys(types).map(function (t) {
        return '<option value="' + t + '">' + t + "</option>";
      }).join("");

    function parseRp(v) {
      if (!v) return null;
      var n = v.replace(/[^0-9]/g, "");
      return n ? parseInt(n, 10) : null;
    }

    function apply() {
      state.type = typeEl.value;
      state.status = statusEl.value;
      state.min = minEl.value;
      state.max = maxEl.value;

      var result = C.properties.filter(function (p) {
        if (state.status && p.status !== state.status) return false;
        if (state.type && p.type !== state.type) return false;
        var min = parseRp(state.min), max = parseRp(state.max);
        var price = parseRp(p.price);
        if (price && min !== null && price < min) return false;
        if (price && max !== null && price > max) return false;
        return true;
      });

      if (!result.length) {
        list.innerHTML =
          '<div class="notfound" style="grid-column:1/-1"><i class="fa-solid fa-magnifying-glass"></i>' +
          "<h2>Properti tidak ditemukan</h2><p>Coba ubah filter pencarian Anda.</p></div>";
        return;
      }
      list.innerHTML = result.map(function (p, i) { return propertyCard(p, i); }).join("");
    }

    typeEl.addEventListener("change", apply);
    statusEl.addEventListener("change", apply);
    minEl.addEventListener("change", apply);
    maxEl.addEventListener("change", apply);
    var reset = $("#f-reset");
    if (reset) {
      reset.addEventListener("click", function () {
        typeEl.value = ""; statusEl.value = ""; minEl.value = ""; maxEl.value = "";
        apply();
      });
    }
    apply();
  }

  function renderPropertyDetail() {
    var slug = param("slug");
    var p = C.properties.filter(function (x) { return x.slug === slug; })[0];
    var mount = $("#property-detail");
    if (!mount) return;

    if (!p) {
      mount.innerHTML =
        '<div class="notfound"><i class="fa-solid fa-house-circle-xmark"></i><h2>Properti tidak ditemukan</h2>' +
        '<a class="btn btn-primary" href="properti.html">Kembali ke Properti</a></div>';
      document.title = "Properti Tidak Ditemukan — DJM";
      return;
    }

    document.title = p.title + " — DJM Desty Jaya Mandiri";
    var meta = document.querySelector('meta[name="description"]');
    if (meta) meta.setAttribute("content", p.short);

    var facts =
      '<div class="facts">' +
      '<div class="fact"><i class="fa-solid fa-ruler-combined"></i><b>' + p.land + "</b><span>Luas Tanah</span></div>" +
      '<div class="fact"><i class="fa-solid fa-vector-square"></i><b>' + p.building + "</b><span>Luas Bangunan</span></div>" +
      '<div class="fact"><i class="fa-solid fa-bed"></i><b>' + p.bedrooms + "</b><span>Kamar Tidur</span></div>" +
      '<div class="fact"><i class="fa-solid fa-bath"></i><b>' + p.bathrooms + "</b><span>Kamar Mandi</span></div>" +
      "</div>";

    var related = C.properties.filter(function (x) { return x.slug !== p.slug; })
      .slice(0, 3).map(function (x, i) { return propertyCard(x, i); }).join("");

    mount.innerHTML =
      '<div class="page-header"><div class="container">' +
      '<p class="breadcrumb"><a href="index.html">Beranda</a> / <a href="properti.html">Properti</a> / ' + p.title + "</p>" +
      statusBadge(p.status) + " &nbsp; " +
      '<span class="service-tag" style="vertical-align:middle">' + p.type + "</span>" +
      "<h1>" + p.title + "</h1>" +
      "<p><i class=\"fa-solid fa-location-dot\"></i> " + p.location + "</p></div></div>" +
      '<div class="container"><div class="detail-grid">' +
      '<div class="detail-media" style="background:' + phColor(p.slug.length) +
      ';display:flex;align-items:center;justify-content:center;color:rgba(84,172,191,.6);font-size:4rem;">' +
      '<i class="fa-solid fa-house-chimney"></i></div>' +
      '<div class="detail-info">' +
      '<div class="d-title">' + p.title + "</div>" +
      '<div class="d-price">' + p.price + "</div>" +
      '<p class="d-meta"><i class="fa-solid fa-location-dot"></i>' + p.location + "</p>" +
      facts +
      '<div class="d-block"><h2><i class="fa-solid fa-align-left"></i>Deskripsi</h2><p>' + p.desc + "</p></div>" +
      (p.facilities.length
        ? '<div class="d-block"><h2><i class="fa-solid fa-star"></i>Fasilitas</h2><ul>' +
          p.facilities.map(function (f) { return "<li>" + f + "</li>"; }).join("") + "</ul></div>"
        : "") +
      '<div class="wa-panel">' +
      "<h2>Tertarik dengan properti ini?</h2>" +
      "<p>Tanyakan ketersediaan dan dapatkan info lengkap via WhatsApp.</p>" +
      '<a class="btn btn-white" target="_blank" rel="noopener" href="' +
      waLink("Halo DJM, saya tertarik dengan properti " + p.title + " dengan harga " + p.price + ". Saya ingin mendapatkan informasi lebih lanjut.") +
      '"><i class="fa-brands fa-whatsapp"></i> Tanyakan via WhatsApp</a></div>' +
      "</div></div></div>" +
      '<section class="section section-bg-white"><div class="container">' +
      '<div class="section-head"><h2 class="section-title">Properti Lainnya</h2></div>' +
      '<div class="related-grid">' + related + "</div></div></section>";
  }

  /* ── Render: Portfolio ───────────────────────────────────── */
  var PORT_CATS = {
    perizinan: { label: "Perizinan", icon: "fa-solid fa-file-shield" },
    konstruksi: { label: "Konstruksi", icon: "fa-solid fa-helmet-safety" },
    property: { label: "Property", icon: "fa-solid fa-house-chimney" },
    lain: { label: "Lainnya", icon: "fa-solid fa-folder-open" },
  };

  function portfolioCard(pt, i) {
    var cat = PORT_CATS[pt.category] || PORT_CATS.lain;
    return (
      '<article class="card portfolio-card">' +
      mediaPlaceholder(phColor(i + 1), cat.icon, pt.category) +
      '<div class="card-body">' +
      '<span class="service-tag">' + cat.label + "</span>" +
      "<h3>" + pt.title + "</h3>" +
      '<p class="location"><i class="fa-solid fa-location-dot"></i>' + pt.location +
      " &middot; <i class=\"fa-regular fa-calendar\"></i> " + pt.year + "</p>" +
      '<p class="desc">' + pt.short + "</p>" +
      "</div></article>"
    );
  }

  function renderPortfolio() {
    var list = $("#portfolio-list");
    if (!list) return;
    list.innerHTML = C.portfolios.map(portfolioCard).join("");

    var fil = $("#p-cat");
    if (fil) {
      fil.addEventListener("change", function () {
        var val = fil.value;
        var items = val ? C.portfolios.filter(function (p) { return p.category === val; }) : C.portfolios;
        if (!items.length) {
          list.innerHTML =
            '<div class="notfound" style="grid-column:1/-1"><i class="fa-solid fa-folder-open"></i>' +
            "<h2>Portfolio tidak ditemukan</h2></div>";
          return;
        }
        list.innerHTML = items.map(portfolioCard).join("");
      });
    }
  }

  /* ── Render: Contact form → WhatsApp ─────────────────────── */
  function bindContactForm() {
    var form = $("#contact-form");
    if (form) {
      form.addEventListener("submit", function (e) {
        e.preventDefault();
        var nama = $("#cf-name").value.trim();
        var subjek = $("#cf-subject").value;
        var pesan = $("#cf-message").value.trim();
        if (!nama) { $("#cf-name").focus(); return; }
        var text = "Halo DJM, saya " + nama + ".\n\n" +
          (pesan ? pesan + "\n\n" : "") +
          (subjek ? "Topik: " + subjek : "");
        window.open(waLink(text), "_blank", "noopener");
      });
    }

    $$("[data-cta-wa]").forEach(function (a) {
      a.href = waLink("Halo DJM, saya ingin berkonsultasi.");
    });
  }

  function renderContact() {
    var el = $("#contact-list");
    if (!el) return;
    el.innerHTML =
      '<div class="contact-row"><div class="c-icon"><i class="fa-solid fa-location-dot"></i></div>' +
      "<div><b>Alamat</b><p>" + C.address + "</p></div></div>" +
      '<div class="contact-row"><div class="c-icon"><i class="fa-solid fa-phone"></i></div>' +
      "<div><b>Telepon</b><p><a href=\"tel:" + C.phoneRaw + '">' + C.phone + "</a></p></div></div>" +
      '<div class="contact-row"><div class="c-icon"><i class="fa-brands fa-whatsapp"></i></div>' +
      "<div><b>WhatsApp</b><p><a href=\"" + waLink("Halo DJM!") + '" target="_blank" rel="noopener">+' + C.wa + "</a></p></div></div>" +
      '<div class="contact-row"><div class="c-icon"><i class="fa-solid fa-envelope"></i></div>' +
      "<div><b>Email</b><p><a href=\"mailto:" + C.email + '">' + C.email + "</a></p></div></div>" +
      '<div class="contact-row"><div class="c-icon"><i class="fa-solid fa-clock"></i></div>' +
      "<div><b>Jam Operasional</b><p>" + C.hours + "</p></div></div>";
  }

  /* ── Init ────────────────────────────────────────────────── */
  function init() {
    buildHeader();
    buildFooter();
    buildWA();
    bindContactForm();

    var page = document.body.dataset.page || "";
    if (page === "home") renderHome();
    else if (page === "layanan") renderServices();
    else if (page === "layanan-detail") renderServiceDetail();
    else if (page === "properti") renderProperties();
    else if (page === "properti-detail") renderPropertyDetail();
    else if (page === "portofolio") renderPortfolio();
    else if (page === "kontak") renderContact();
  }

  /* Script dimuat di akhir <body>, DOM sudah siap — langsung init. */
  init();
})();
