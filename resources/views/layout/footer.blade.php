<footer>
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <a class="alma-logo-wrap footer-alma-logo" href="{{ locale_route('home') }}#top">
                    <div class="alma-logo-canvas-wrap">
                        <canvas class="alma-logo-canvas" width="120" height="120"></canvas>
                    </div>
                    <div class="alma-logo-text">
                        <span class="logo-main">ALMA</span>
                        <div class="logo-sub">
                            <span>B</span><span>A</span><span>L</span><span>A</span><span>B</span><span>A</span><span>Q</span><span>S</span><span>H</span><span>A</span><span>S</span><span>Y</span>
                        </div>
                    </div>
                </a>
                <p style="font-size:.88rem;line-height:1.7;max-width:280px;margin-top:12px;">
                    Частный детский сад с лицензией Министерства образования РК. Работаем с 2012 года.
                </p>
                <div class="d-flex gap-2 mt-3">
                    <a href="#" style="width:36px;height:36px;border-radius:10px;background:rgba(255,255,255,.1);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.7);font-size:1.1rem;text-decoration:none;" class="wobble">📘</a>
                    <a href="#" style="width:36px;height:36px;border-radius:10px;background:rgba(255,255,255,.1);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.7);font-size:1.1rem;text-decoration:none;" class="wobble">📸</a>
                    <a href="#" style="width:36px;height:36px;border-radius:10px;background:rgba(255,255,255,.1);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.7);font-size:1.1rem;text-decoration:none;" class="wobble">💬</a>
                </div>
            </div>
            <div class="col-sm-4 col-lg-2">
                <h6>Садик</h6>
                <a href="#">О нас</a>
                <a href="#">Программы</a>
                <a href="#">Педагоги</a>
                <a href="#">Галерея</a>
            </div>
            <div class="col-sm-4 col-lg-2">
                <h6>Родителям</h6>
                <a href="#">Как записаться</a>
                <a href="{{ locale_route('documents.index') }}">{{ __('footer_documents') }}</a>
                <a href="#">Питание</a>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 footer-copy">
            <span>© 2024 Alma Balabaqshasy. Все права защищены.</span>
            <div class="d-flex gap-3">
                <a href="#">Политика конфиденциальности</a>
                <a href="#">Лицензия</a>
            </div>
        </div>
    </div>
</footer>
