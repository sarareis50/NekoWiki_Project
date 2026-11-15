<?php
/**
 * DokuWiki Fictive Template
 * Based on the starter template and a wordpress theme of the same name
 *
 * @link     http://dokuwiki.org/template:fictive
 * @author   desbest <afaninthehouse@gmail.com>
 * @license  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

if (!defined('DOKU_INC')) die(); /* must be run from within DokuWiki */
@require_once(dirname(__FILE__).'/tpl_functions.php'); /* include hook for template functions */
header('X-UA-Compatible: IE=edge,chrome=1');

$showTools = !tpl_getConf('hideTools') || ( tpl_getConf('hideTools') && !empty($_SERVER['REMOTE_USER']) );
$showSidebar = page_findnearest($conf['sidebar']) && ($ACT=='show');
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang'] ?>"
  lang="<?php echo $conf['lang'] ?>" dir="<?php echo $lang['direction'] ?>" class="no-js">
<head>
    <meta charset="UTF-8" />
    <title><?php tpl_pagetitle() ?> [<?php echo strip_tags($conf['title']) ?>]</title>
    <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
    <?php tpl_metaheaders() ?>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <?php echo tpl_favicon(array('favicon', 'mobile')) ?>
    <?php tpl_includeFile('meta.html') ?>
    <script defer type="text/javascript" src="<?php echo tpl_basedir();?>/fictive.js"></script>
    <link rel='stylesheet' id='fictive-open-sans-css'  href='http://fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C700italic%2C400%2C300%2C700&#038;ver=5.4.4' type='text/css' media='all' />
    <link rel='stylesheet' id='fictive-bitter-css'  href='http://fonts.googleapis.com/css?family=Bitter%3A400%2C700%2C400italic&#038;subset=latin%2Clatin-ext&#038;ver=5.4.4' type='text/css' media='all' />
</head>

<body id="dokuwiki__top" class="<?php echo tpl_classes(); ?> <?php
        echo ($showSidebar) ? 'hasSidebar' : ''; ?>">

<div id="page" class="hfeed site">

    <header id="masthead" class="site-header" role="banner">
        <a href="/" rel="home">
            <!-- header image -->
            <img src="<?php echo tpl_basedir();?>/images/header.jpg" alt="" class="header-image" width="1112" height="1000">
        </a>
        <div class="site-branding">
                <div class="header-avatar">
                    <a href="" rel="home">
                        <!-- <img src="" width="70" height="70" alt=""> -->
                    </a>
                </div>
            <h1 class="site-title"><?php tpl_link(wl(),$conf['title'],'accesskey="h" title="[H]"') ?></h1>
            <?php if ($conf['tagline']): ?><h2 class="site-description"><?php echo $conf['tagline'] ?></h2><?php endif; ?>

            <ul class="a11y skip">
                    <li><a href="#dokuwiki__content"><?php echo $lang['skip_to_content'] ?></a></li>
                </ul>

                <?php /* how to insert logo instead (if no CSS image replacement technique is used):
                        upload your logo into the data/media folder (root of the media manager) and replace 'logo.png' accordingly:
                        tpl_link(wl(),'<img src="'.ml('logo.png').'" alt="'.$conf['title'].'" />','id="dokuwiki__top" accesskey="h" title="[H]"') */ ?>
               
            <!-- social menu -->
                <div class="social-links">
                    <!-- menu goes here -->
                </div>
        </div>

        <div class="menu-toggles clear">
                <!-- primary menu -->
                <h1 id="menu-toggle" class="menu-toggle"><span class="screen-reader-text">menu</span></h1>
                <!-- sidebar 1 -->
                <h1 id="document-toggle" class="menu-toggle"><span class="screen-reader-text">widgets</span></h1>
            <h1 id="search-toggle" class="menu-toggle"><span class="screen-reader-text">search</span></h1>
        </div>

        <nav  class="header-search" role="navigation">
            <?php tpl_searchform() ?>
        </nav>

        <nav  class="document-tools mobile" role="navigation">
            <ul id="" class="menu">
                <?php tpl_toolsevent('pagetools', array(
                    'edit'      => tpl_action('edit', 1, 'li', 1),
                    'discussion'=> _tpl_action('discussion', 1, 'li', 1),
                    'revisions' => tpl_action('revisions', 1, 'li', 1),
                    'backlink'  => tpl_action('backlink', 1, 'li', 1),
                    'subscribe' => tpl_action('subscribe', 1, 'li', 1),
                    'revert'    => tpl_action('revert', 1, 'li', 1),
                    //'top'       => tpl_action('top', 1, 'li', 1),
                )); ?>
            </ul>
        </nav>

        <nav  class="main-navigation" role="navigation">

            <!-- ********** ASIDE ********** -->
            <?php if ($showSidebar): ?>
                <div id="writtensidebar">
                    <?php tpl_includeFile('sidebarheader.html') ?>
                    <?php tpl_include_page($conf['sidebar'], 1, 1) /* includes the nearest sidebar page */ ?>
                    <?php tpl_includeFile('sidebarfooter.html') ?>
                    <div class="clearer"></div>
                </div><!-- /aside -->
            <?php endif; ?>
            
            <a class="skip-link screen-reader-text" href="#content"><!-- skip to content --></a>
            <div class="">
            <div class="desktop"><?php tpl_searchform() ?></div>
             <?php
            if (!empty($_SERVER['REMOTE_USER'])) {
                echo '<li class="user">';
                tpl_userinfo(); /* 'Logged in as ...' */
                echo '</li>';
            }
            ?><ul id="" class="menu">
                <?php tpl_toolsevent('sitetools', array(
                            'recent'    => tpl_action('recent', 1, 'li', 1),
                            'media'     => tpl_action('media', 1, 'li', 1),
                            'index'     => tpl_action('index', 1, 'li', 1),
                )); ?>
                <!-- USER TOOLS -->
                <?php if ($conf['useacl'] && $showTools): ?>
                    <!-- <div id="dokuwiki__usertools"> -->
                        
                        <!-- <ul> -->
                           
                            <?php /* the optional second parameter of tpl_action() switches between a link and a button,
                                     e.g. a button inside a <li> would be: tpl_action('edit', 0, 'li') */
                            ?>
                            <?php tpl_toolsevent('usertools', array(
                                'admin'     => tpl_action('admin', 1, 'li', 1),
                                'userpage'  => _tpl_action('userpage', 1, 'li', 1),
                                'profile'   => tpl_action('profile', 1, 'li', 1),
                                'register'  => tpl_action('register', 1, 'li', 1),
                                'login'     => tpl_action('login', 1, 'li', 1),
                            )); ?>
                        <!-- </ul> -->
                    <!-- </div> -->
                <?php endif ?>
            </ul></div>
            <!-- primary menu -->

        </nav><!-- #site-navigation -->

        <!-- sidebar here -->

        <div id="site-search" class="header-search">
            <!-- search form -->
        </div>
    </header><!-- #masthead -->



    <div id="content" class="site-content">

         <?php tpl_includeFile('header.html') ?>
         <!-- BREADCRUMBS -->
                 <div style="padding-bottom: 2em;">
                <?php if($conf['breadcrumbs']){ ?>
                    <div class="breadcrumbs"><?php tpl_breadcrumbs() ?></div>
                <?php } ?>
                <?php if($conf['youarehere']){ ?>
                    <div class="breadcrumbs"><?php tpl_youarehere() ?></div>
                <?php } ?>
                </div>


        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">

            <div class="hentry-wrapper">
                <figure class="entry-thumbnail">
                <a href="" rel="bookmark"></a>
                </figure>


                <article id="post-9" class="post-9 post type-post status-publish format-standard has-post-thumbnail hentry category-uncategorized">
                <!-- <header class="entry-header">
                            <h1 class="entry-title"><a href="http://localhost/wordpress/test-post/" rel="bookmark">Test post</a></h1>                       <div class="entry-meta">
                                    <span class="post-date"><a href="http://localhost/wordpress/test-post/" title="7:11 pm" rel="bookmark"><time class="entry-date" datetime="2020-02-04T19:11:31+00:00">February 4, 2020</time></a></span><span class="byline"><span class="author vcard"><a class="url fn n" href="http://localhost/wordpress/author/desbest/" title="View all posts by desbest" rel="author">desbest</a></span></span>               
                                <span class="comments-link"><a href="http://localhost/wordpress/test-post/#comments">2 Comments</a></span>
                
                            </div>
        </header> --><!-- .entry-header -->

                <div class="entry-content">

                    <!-- PAGE ACTIONS -->
                    <?php if ($showTools): ?>
                        <!-- <div id="dokuwiki__pagetools"> -->
                            <h3 class="a11y"><?php echo $lang['page_tools'] ?></h3>
                            
                            <nav  class="main-navigation inlinemenu" role="navigation"><div class=""><ul id="" class="menu">
                                <?php tpl_toolsevent('pagetools', array(
                                    'edit'      => tpl_action('edit', 1, 'li', 1),
                                    'discussion'=> _tpl_action('discussion', 1, 'li', 1),
                                    'revisions' => tpl_action('revisions', 1, 'li', 1),
                                    'backlink'  => tpl_action('backlink', 1, 'li', 1),
                                    'subscribe' => tpl_action('subscribe', 1, 'li', 1),
                                    'revert'    => tpl_action('revert', 1, 'li', 1),
                                    //'top'       => tpl_action('top', 1, 'li', 1),
                                )); ?>
                            </ul><!-- </div> --></nav>
                        <!-- </div> -->
                    <?php endif; ?>

                     <?php tpl_flush() /* flush the output buffer */ ?>
                    <?php tpl_includeFile('pageheader.html') ?>

                    <div class="page">
                        <!-- wikipage start -->
                        <?php tpl_content() /* the main content */ ?>
                        <!-- wikipage stop -->
                        <div class="clearer"></div>
                    </div>

                    <?php tpl_flush() ?>
                    <?php tpl_includeFile('pagefooter.html') ?>
                </div><!-- .entry-content -->
        
        <footer class="entry-footer entry-meta">

                                                </footer><!-- .entry-footer -->
    </article>

            <?php //fictive_post_nav(); ?>

            <?php
                // If comments are open or we have at least one comment, load up the comment template
                // if ( comments_open() || '0' != get_comments_number() ) :
                //     comments_template();
                // endif;
            ?>

            </main><!-- #main -->
        </div><!-- #primary -->

    </div><!-- #content -->

    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="site-info">
            <div class="doc"><?php tpl_pageinfo() /* 'Last modified' etc */ ?></div>
            <?php tpl_license('button') /* content license, parameters: img=*badge|button|0, imgonly=*0|1, return=*0|1 */ ?>

            <a href="http://dokuwiki.org">Powered by dokuwiki</a>
            <span class="sep"> | </span>
            Fictive theme by Automattic
            <?php tpl_includeFile('footer.html') ?>
        </div><!-- .site-info -->
    </footer><!-- #colophon -->
    <?php html_msgarea() /* occasional error and info messages on top of the page */ ?>
</div><!-- #page -->


    <!-- end of fictive -->

    <?php /* with these Conditional Comments you can better address IE issues in CSS files,
             precede CSS rules by #IE8 for IE8 (div closes at the bottom) */ ?>
    <!--[if lte IE 8 ]><div id="IE8"><![endif]-->

    <?php /* the "dokuwiki__top" id is needed somewhere at the top, because that's where the "back to top" button/link links to */ ?>
    <?php /* tpl_classes() provides useful CSS classes; if you choose not to use it, the 'dokuwiki' class at least
             should always be in one of the surrounding elements (e.g. plugins and templates depend on it) */ ?>



    <div class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>
</body>
</html>
