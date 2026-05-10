<?php
/* NOTÍCIA 365 - ENGINE DE METADADOS (PHP)
    Desenvolvido para: Donaldo F. Rodrigues (DOFERO)
*/

$noticia_id = isset($_GET['noticia']) ? $_GET['noticia'] : null;
$og_title = "Notícia 365 | O Maior Agregador de Moçambique";
$og_image = "https://via.placeholder.com/1200x630/cc0000/ffffff?text=Noticia+365"; // Substitua pelo seu logo real
$og_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if ($noticia_id) {
    $partes = explode('-', $noticia_id);
    $slug_fonte = $partes[0];
    $id_real = $partes[1];

    $fontes_api = [
        "opais" => "https://opais.co.mz/wp-json/wp/v2/posts/",
        "carta" => "https://cartamz.com/wp-json/wp/v2/posts/",
        "mznews" => "https://mznews.co.mz/wp-json/wp/v2/posts/",
        "folha" => "https://www.folhademaputo.co.mz/wp-json/wp/v2/posts/",
        "evidencias" => "https://evidencias.co.mz/wp-json/wp/v2/posts/",
        "integrity" => "https://integritymagazine.co.mz/wp-json/wp/v2/posts/",
        "savana" => "https://savana.co.mz/wp-json/wp/v2/posts/",
        "aim" => "https://aimnews.org/wp-json/wp/v2/posts/",
        "noticias" => "https://www.jornalnoticias.co.mz/wp-json/wp/v2/posts/",
        "diario" => "https://www.diarioeconomico.co.mz/wp-json/wp/v2/posts/",
        "timesdetodos" => "https://www.timesdetodos.com/wp-json/wp/v2/posts/",
        "360moz" => "https://360mozambique.com/wp-json/wp/v2/posts/",
        "oeconomico" => "https://www.oeconomico.com/wp-json/wp/v2/posts/",
        "clubmz" => "https://clubofmozambique.com/wp-json/wp/v2/posts/",
        "ikweli" => "https://ikweli.co.mz/wp-json/wp/v2/posts/",
        "rigor" => "https://jornalrigor.co.mz/wp-json/wp/v2/posts/",
        "desafio" => "https://www.jornaldesafio.co.mz/wp-json/wp/v2/posts/",
        "canal" => "https://canal.co.mz/wp-json/wp/v2/posts/",
        "wamphula" => "https://www.wamphulafax.co.mz/wp-json/wp/v2/posts/",
        "moztimes" => "https://moztimes.com/wp-json/wp/v2/posts/",
        "zumbo" => "https://zumbofm.com/wp-json/wp/v2/posts/",
        "zitamar" => "https://www.zitamar.com/wp-json/wp/v2/posts/",
        "chuabo" => "https://chuabofm.com/wp-json/wp/v2/posts/",
        "cdd" => "https://cddmoz.org/wp-json/wp/v2/posts/",
        "cip" => "https://www.cipmoz.org/wp-json/wp/v2/posts/",
        "pdecide" => "https://pdecide.org/wp-json/wp/v2/posts/",
        "domingo" => "https://jornaldomingo.co.mz/wp-json/wp/v2/posts/",
        "destaque" => "https://odestaque.co.mz/wp-json/wp/v2/posts/"
    ];

    if (isset($fontes_api[$slug_fonte])) {
        $api_url = $fontes_api[$slug_fonte] . $id_real . "?_embed";
        $ctx = stream_context_create(['http' => ['timeout' => 2]]);
        $json = @file_get_contents($api_url, false, $ctx);
        if ($json) {
            $data = json_decode($json, true);
            if (isset($data['title']['rendered'])) {
                $og_title = strip_tags($data['title']['rendered']);
                if (isset($data['_embedded']['wp:featuredmedia'][0]['source_url'])) {
                    $og_image = $data['_embedded']['wp:featuredmedia'][0]['source_url'];
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-MZ">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    
    <title><?php echo $og_title; ?></title>
    <meta property="og:title" content="<?php echo $og_title; ?>">
    <meta property="og:image" content="<?php echo $og_image; ?>">
    <meta property="og:url" content="<?php echo $og_url; ?>">
    <meta property="og:type" content="article">
    <meta property="og:description" content="Acompanhe as últimas notícias de Moçambique no maior agregador nacional.">
    <meta name="twitter:card" content="summary_large_image">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;0,900;1,400&family=Lora:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root { 
            --primary: #dc2626; --primary-dark: #991b1b; --accent: #0f172a; --bg: #f8fafc; 
            --header-bg: #ffffff; --card: #ffffff; --text: #0f172a; --text-meta: #64748b; 
            --text-article: #334155; --border: #e2e8f0; --shadow-soft: 0 4px 15px rgba(0, 0, 0, 0.06);
            --font-ui: 'Plus Jakarta Sans', sans-serif; --font-serif: 'Playfair Display', serif; 
            --font-reading: 'Lora', serif; --nav-height: 65px; 
        }
        body.dark-mode { 
            --bg: #020617; --header-bg: #0f172a; --card: #0f172a; --text: #f8fafc; 
            --text-meta: #94a3b8; --text-article: #cbd5e1; --border: #1e293b; --primary: #ef4444; 
        }
        * { box-sizing: border-box; margin: 0; padding: 0; -webkit-tap-highlight-color: transparent; }
        body { font-family: var(--font-ui); background: var(--bg); color: var(--text); overflow-x: hidden; padding-bottom: calc(var(--nav-height) + 20px); transition: background 0.4s; }
        
        .app-view { display: none; width: 100%; min-height: 100vh; position: absolute; top: 0; left: 0; background: var(--bg); padding-bottom: 80px; }
        .app-view.active-fade { display: block; animation: fadeIn 0.4s forwards; }
        .app-view.active-slide { display: block; animation: slideInRight 0.4s forwards; z-index: 50; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        /* Headers e Navs */
        .app-header { position: sticky; top: 0; background: var(--header-bg); z-index: 1000; border-bottom: 1px solid var(--border); }
        .app-header-inner { display: flex; justify-content: space-between; align-items: center; max-width: 1200px; margin: 0 auto; padding: 10px 15px; height: 60px; }
        .logo { font-family: var(--font-serif); font-weight: 900; font-size: 1.5rem; color: var(--text); text-decoration: none; text-transform: uppercase; }
        .logo span { color: var(--primary); }
        
        /* Feed de Cards */
        .feed { padding: 0 15px; max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 18px; }
        .news-card { position: relative; height: 260px; border-radius: 14px; overflow: hidden; cursor: pointer; background: #000; box-shadow: var(--shadow-soft); transition: 0.3s; }
        .news-card:hover { transform: translateY(-5px); }
        .news-img { width: 100%; height: 100%; object-fit: cover; opacity: 0.7; transition: 0.6s; }
        .news-card:hover .news-img { transform: scale(1.08); opacity: 0.5; }
        .news-body { position: absolute; bottom: 0; left: 0; width: 100%; padding: 20px 15px; z-index: 2; background: linear-gradient(transparent, rgba(0,0,0,0.9)); }
        .news-tag { background: var(--primary); color: #fff; padding: 4px 10px; border-radius: 6px; font-size: 0.6rem; font-weight: 800; text-transform: uppercase; margin-bottom: 8px; display: inline-block; }
        .news-title { font-family: var(--font-serif); font-size: 1.1rem; font-weight: 800; line-height: 1.3; color: #fff; }

        /* Fabs Flutuantes Direita */
        .home-fabs { position: fixed; right: 15px; bottom: calc(var(--nav-height) + 15px); display: flex; flex-direction: column; gap: 12px; z-index: 1500; }
        .fab-action { width: 50px; height: 50px; border-radius: 50%; border: none; color: white; font-size: 1.2rem; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 8px 20px rgba(0,0,0,0.3); }
        .fab-share-app { background: #10b981; animation: pulse 2s infinite; }
        .fab-refresh-feed { background: var(--primary); }
        @keyframes pulse { 0% { box-shadow: 0 0 0 0 rgba(16,185,129,0.5); } 100% { box-shadow: 0 0 0 12px rgba(16,185,129,0); } }

        /* Bottom Nav */
        .bottom-nav { position: fixed; bottom: 0; left: 0; width: 100%; height: var(--nav-height); background: var(--header-bg); border-top: 1px solid var(--border); display: flex; justify-content: space-around; align-items: center; z-index: 2000; box-shadow: 0 -5px 20px rgba(0,0,0,0.05); }
        .nav-item { display: flex; flex-direction: column; align-items: center; color: var(--text-meta); font-size: 0.65rem; font-weight: 700; cursor: pointer; flex: 1; }
        .nav-item.active { color: var(--primary); }
        .badge-counter { position: absolute; top: -5px; right: -8px; background: var(--primary); color: #fff; font-size: 0.55rem; width: 16px; height: 16px; border-radius: 50%; display: none; align-items: center; justify-content: center; }

        /* Estilo do Artigo */
        .article-hero { position: relative; width: 100%; height: 350px; background: #000; }
        .article-hero-img { width: 100%; height: 100%; object-fit: cover; opacity: 0.8; }
        .article-hero-content { position: absolute; bottom: 0; padding: 30px 20px; background: linear-gradient(transparent, rgba(0,0,0,0.9)); width: 100%; }
        .article-hero-title { color: #fff; font-family: var(--font-serif); font-size: 1.6rem; font-weight: 900; }
        .article-actions-bar { display: flex; gap: 8px; padding: 15px; background: var(--card); border-bottom: 1px solid var(--border); }
        .btn-premium { flex: 1; border: none; border-radius: 10px; padding: 10px; color: #fff; font-weight: 800; font-size: 0.6rem; text-transform: uppercase; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 4px; }
        .btn-voltar { background: #64748b; } .btn-inicio { background: #0284c7; } .btn-guardar { background: #d97706; } .btn-partilhar { background: #10b981; }
        .article-content { padding: 20px; font-family: var(--font-reading); line-height: 1.8; color: var(--text-article); font-size: 1.1rem; }
    </style>
</head>
<body class="<?php echo isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark' ? 'dark-mode' : ''; ?>">

<header class="app-header" id="main-header">
    <div class="app-header-inner">
        <a href="javascript:void(0)" class="logo" onclick="switchTab('home')">Notícia<span>365</span></a>
        <button class="icon-btn" onclick="toggleTheme()" style="background:none; border:none; color:var(--text); font-size:1.2rem; cursor:pointer;"><i class="fas fa-adjust"></i></button>
    </div>
</header>

<div id="home-view" class="app-view active-fade">
    <div class="feed" id="feed" style="margin-top:20px;"></div>
    <div id="scroll-anchor" style="text-align:center; padding:20px; color:var(--text-meta);"><i class="fas fa-spinner fa-spin"></i> A carregar Moçambique...</div>
</div>

<div class="home-fabs" id="home-fabs">
    <button class="fab-action fab-share-app" onclick="shareAppGlobal()"><i class="fas fa-share-nodes"></i></button>
    <button class="fab-action fab-refresh-feed" onclick="manualRefresh()"><i class="fas fa-sync-alt" id="refresh-icon"></i></button>
</div>

<div id="article-view" class="app-view">
    <div class="article-hero">
        <img id="feat-img" class="article-hero-img">
        <div class="article-hero-content">
            <span id="source-tag" class="news-tag">...</span>
            <h1 id="article-title" class="article-hero-title">...</h1>
        </div>
    </div>
    <div class="article-actions-bar">
        <button class="btn-premium btn-voltar" onclick="goBackHistory()"><i class="fas fa-arrow-left"></i> Voltar</button>
        <button class="btn-premium btn-inicio" onclick="goToHome()"><i class="fas fa-home"></i> Início</button>
        <button class="btn-premium btn-guardar" id="btn-save" onclick="toggleSaveArticle()"><i class="fas fa-bookmark"></i> <span id="save-text">Guardar</span></button>
        <button class="btn-premium btn-partilhar" onclick="shareArticle()"><i class="fas fa-share-nodes"></i> Partilhar</button>
    </div>
    <div id="article-content" class="article-content"></div>
</div>

<nav class="bottom-nav" id="bottom-nav">
    <div class="nav-item active" onclick="switchTab('home', this)"><i class="fas fa-home"></i><span>Explorar</span></div>
    <div class="nav-item" onclick="switchTab('saved', this)" style="position:relative;"><i class="fas fa-bookmark"></i><span>Guardados</span><span class="badge-counter" id="saved-badge">0</span></div>
    <div class="nav-item" onclick="switchTab('menu', this)"><i class="fas fa-bars"></i><span>Menu</span></div>
</nav>

<script>
// CONFIGURAÇÃO DAS FONTES (Mantendo as 28 que adicionamos)
const SOURCES = [
    { name: "O País", api: "https://opais.co.mz/wp-json/wp/v2/posts", slug: "opais" },
    { name: "Carta de MZ", api: "https://cartamz.com/wp-json/wp/v2/posts", slug: "carta" },
    { name: "MZ News", api: "https://mznews.co.mz/wp-json/wp/v2/posts", slug: "mznews" },
    { name: "Folha de Maputo", api: "https://www.folhademaputo.co.mz/wp-json/wp/v2/posts", slug: "folha" },
    { name: "Evidências", api: "https://evidencias.co.mz/wp-json/wp/v2/posts", slug: "evidencias" },
    { name: "Integrity Mag", api: "https://integritymagazine.co.mz/wp-json/wp/v2/posts", slug: "integrity" },
    { name: "Savana", api: "https://savana.co.mz/wp-json/wp/v2/posts", slug: "savana" },
    { name: "AIM News", api: "https://aimnews.org/wp-json/wp/v2/posts", slug: "aim" },
    { name: "Jornal Notícias", api: "https://www.jornalnoticias.co.mz/wp-json/wp/v2/posts", slug: "noticias" },
    { name: "Diário Económico", api: "https://www.diarioeconomico.co.mz/wp-json/wp/v2/posts", slug: "diario" },
    { name: "Times de Todos", api: "https://www.timesdetodos.com/wp-json/wp/v2/posts", slug: "timesdetodos" },
    { name: "360 Mozambique", api: "https://360mozambique.com/wp-json/wp/v2/posts", slug: "360moz" },
    { name: "O Económico", api: "https://www.oeconomico.com/wp-json/wp/v2/posts", slug: "oeconomico" },
    { name: "Club of Moz", api: "https://clubofmozambique.com/wp-json/wp/v2/posts", slug: "clubmz" },
    { name: "Ikweli", api: "https://ikweli.co.mz/wp-json/wp/v2/posts", slug: "ikweli" },
    { name: "Jornal Rigor", api: "https://jornalrigor.co.mz/wp-json/wp/v2/posts", slug: "rigor" },
    { name: "Jornal Desafio", api: "https://www.jornaldesafio.co.mz/wp-json/wp/v2/posts", slug: "desafio" },
    { name: "Canal de Moz", api: "https://canal.co.mz/wp-json/wp/v2/posts", slug: "canal" },
    { name: "Wamphula Fax", api: "https://www.wamphulafax.co.mz/wp-json/wp/v2/posts", slug: "wamphula" },
    { name: "Moz Times", api: "https://moztimes.com/wp-json/wp/v2/posts", slug: "moztimes" },
    { name: "Zumbo FM", api: "https://zumbofm.com/wp-json/wp/v2/posts", slug: "zumbo" },
    { name: "Zitamar", api: "https://www.zitamar.com/wp-json/wp/v2/posts", slug: "zitamar" },
    { name: "Chuabo FM", api: "https://chuabofm.com/wp-json/wp/v2/posts", slug: "chuabo" },
    { name: "CDD Moz", api: "https://cddmoz.org/wp-json/wp/v2/posts", slug: "cdd" },
    { name: "CIP Moz", api: "https://www.cipmoz.org/wp-json/wp/v2/posts", slug: "cip" },
    { name: "PDecide", api: "https://pdecide.org/wp-json/wp/v2/posts", slug: "pdecide" },
    { name: "Jornal Domingo", api: "https://jornaldomingo.co.mz/wp-json/wp/v2/posts", slug: "domingo" },
    { name: "O Destaque", api: "https://odestaque.co.mz/wp-json/wp/v2/posts", slug: "destaque" }
];

let allPosts = [], currentPage = 1, isFetching = false, currentReadingPost = null, homeScrollPos = 0;

// FUNCIONAMENTO DO APP (JS Otimizado)
function loadNews() {
    if (isFetching) return;
    isFetching = true;
    let requests = SOURCES.map(src => 
        fetch(`${src.api}?_embed=wp:featuredmedia&per_page=3&page=${currentPage}`)
        .then(r => r.json()).catch(() => [])
    );

    Promise.all(requests).then(results => {
        results.forEach((data, i) => {
            if (!Array.isArray(data)) return;
            data.forEach(p => {
                const id = `${SOURCES[i].slug}-${p.id}`;
                if (!allPosts.some(x => x.id === id)) {
                    allPosts.push({
                        id, title: p.title.rendered, content: p.content.rendered,
                        img: p._embedded?.['wp:featuredmedia']?.[0]?.source_url || "https://via.placeholder.com/600",
                        source: SOURCES[i].name, link: p.link, date: p.date
                    });
                }
            });
        });
        renderFeed();
        isFetching = false;
        currentPage++;
    });
}

function renderFeed() {
    const feed = document.getElementById('feed');
    allPosts.sort((a,b) => new Date(b.date) - new Date(a.date));
    feed.innerHTML = allPosts.map(p => `
        <div class="news-card" onclick="openArticle('${p.id}')">
            <img class="news-img" src="${p.img}" loading="lazy">
            <div class="news-body">
                <span class="news-tag">${p.source}</span>
                <h3 class="news-title">${p.title}</h3>
            </div>
        </div>
    `).join('');
}

function openArticle(id, isHistoryPop = false) {
    const post = allPosts.find(p => p.id === id);
    if (!post) return;
    if (!isHistoryPop) homeScrollPos = window.scrollY;
    
    currentReadingPost = post;
    document.getElementById('article-title').innerHTML = post.title;
    document.getElementById('feat-img').src = post.img;
    document.getElementById('article-content').innerHTML = post.content;
    document.getElementById('source-tag').innerText = post.source;
    
    document.querySelectorAll('.app-view').forEach(v => v.classList.remove('active-fade'));
    document.getElementById('article-view').classList.add('active-slide');
    document.getElementById('bottom-nav').style.transform = 'translateY(100%)';
    document.getElementById('home-fabs').style.display = 'none';

    if (!isHistoryPop) history.pushState({view: 'article', id: post.id}, "", "?noticia=" + post.id);
    window.scrollTo(0,0);
}

function switchTab(tabId, el) {
    if (el) {
        document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
        el.classList.add('active');
    }
    document.querySelectorAll('.app-view').forEach(v => v.classList.remove('active-fade', 'active-slide'));
    document.getElementById(tabId + '-view').classList.add('active-fade');
    document.getElementById('bottom-nav').style.transform = 'translateY(0)';
    document.getElementById('home-fabs').style.display = (tabId === 'home') ? 'flex' : 'none';
    if (tabId === 'home') window.scrollTo(0, homeScrollPos);
}

function toggleTheme() {
    document.body.classList.toggle('dark-mode');
    const isDark = document.body.classList.contains('dark-mode');
    document.cookie = "theme=" + (isDark ? "dark" : "light") + ";path=/";
}

function goBackHistory() { window.history.back(); }
function goToHome() { switchTab('home'); history.pushState({view: 'home'}, "", "index.php"); }

window.onpopstate = (e) => {
    if (e.state?.view === 'article') openArticle(e.state.id, true);
    else switchTab('home', null, true);
};

window.onload = () => {
    loadNews();
    const obs = new IntersectionObserver(e => e[0].isIntersecting && loadNews());
    obs.observe(document.getElementById('scroll-anchor'));
};
</script>
</body>
</html>
