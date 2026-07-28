<footer>
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="footer-brand">
                    <div class="brand-sun sun" style="width:36px;height:36px;font-size:1.1rem;">☀️</div>
                    Солнышко
                </div>
                <p style="font-size:.88rem;line-height:1.7;max-width:280px;">
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
                <a href="#">FAQ</a>
            </div>
            <div class="col-sm-4 col-lg-4">
                <h6>Новости на WhatsApp</h6>
                <p style="font-size:.85rem;line-height:1.6;margin-bottom:12px;">Подпишитесь на нашу рассылку и первыми узнавайте об акциях и событиях.</p>
                <div class="input-group" style="max-width:280px;">
                    <input type="tel" class="form-control" placeholder="+7 (___) ___-__-__" style="border-radius:50px 0 0 50px;border:1.5px solid rgba(255,255,255,.2);background:rgba(255,255,255,.1);color:#fff;font-family:'Nunito',sans-serif;">
                    <button class="btn" type="button" style="border-radius:0 50px 50px 0;background:var(--sun);border:none;color:var(--dark);font-weight:800;padding:0 18px;">OK</button>
                </div>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 footer-copy">
            <span>© 2024 Детский сад «Солнышко». Все права защищены.</span>
            <div class="d-flex gap-3">
                <a href="#">Политика конфиденциальности</a>
                <a href="#">Лицензия</a>
            </div>
        </div>
    </div>
</footer>
