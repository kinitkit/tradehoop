<div class="top1">
    <div class="content row">
        <div class="col-md-6">
            <small>24/7 Customer Service</small> &emsp; <span class="glyphicon glyphicon-earphone phone"></span> <b>0980-502-5232</b>
        </div>
        <div class="col-md-6">
            <div class="pull-right">
                <a href="/login"><span class="glyphicon glyphicon-lock"></span> Login</a>
                <a href="/register"><span class="glyphicon glyphicon-user"></span> Register</a>
            </div>
        </div>
    </div>
</div>
<div class="top2">
    <div class="content row">
        <div class="col-md-6">
            <a href="/"><img class="imgTop" src="{{'images/tradehoop-med.png'}}"/></a>
        </div>
        <div class="col-md-6">
            <div class="search pull-right">
                <form method="post" action="/search">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search" aria-describedby="basic-addon2">
                        <div class="input-group-btn">
                            <button class="button btn"><span class="glyphicon glyphicon-cd"></span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="top3">
    <div class="content row">
        <div class="col-md-12">
            <a {{{ (Request::is('home') ? 'class=active' : '') }}} href="/">HOME</a>
            <a {{{ (Request::is('allcategories') ? 'class=active' : '') }}} href="/allcategories">ALL CATEGORIES</a>
            <a {{{ (Request::is('aboutus') ? 'class=active' : '') }}} href="/aboutus">ABOUT US</a>
            <a {{{ (Request::is('blog') ? 'class=active' : '') }}} href="/blog">BLOG</a>
            <a {{{ (Request::is('customercare') ? 'class=active' : '') }}}  href="/customercare">CUSTOMER CARE</a>
        </div>
    </div>
</div>


