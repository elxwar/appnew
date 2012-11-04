<?php
/**
 * @package    Joomla.Site
 * @subpackage  Templates.beez5
 * @copyright  Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// check modules
$showRightColumn = ($this->countModules('middle-bottom') or $this->countModules('middle-top') or $this->countModules('middle-middle'));
$showbottom = ($this->countModules('position-9') or $this->countModules('position-10') or $this->countModules('position-11'));
$showleft = ($this->countModules('position-4') or $this->countModules('position-7') or $this->countModules('position-5'));
$pageClass = strtolower(str_replace(" ","_",$this->title));
$this->setTitle('Alliance Publishing Press - the independent publisher for the new publishing era');
if ($pageClass != 'home' && $pageClass != 'our_services' && $pageClass != 'app_people' && $pageClass != 'cookies_and_your_privacy' && $pageClass != 'contact_us') {
  $showleftCols = 0;
}

if ($pageClass == 'home'|| ($showRightColumn == 0 and $showleft == 0)) {
  $showno = 0;
}


JHtml::_('behavior.framework', true);

// get params
$color = $this->params->get('templatecolor');
$logo = $this->params->get('logo');
$navposition = $this->params->get('navposition');
$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$templateparams = $app->getTemplate(true)->params;

$doc->addScript($this->baseurl . '/templates/' . $this->template . '/javascript/md_stylechanger.js', 'text/javascript', true);
?>
<?php if (!$templateparams->get('html5', 0)): ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <?php else: ?>
  <?php echo '<!DOCTYPE html>'; ?>
  <?php endif; ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>"
      lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">

  <head>
    <jdoc:include type="head"/>
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/position.css"
          type="text/css" media="screen,projection"/>
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/layout.css"
          type="text/css" media="screen,projection"/>
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/print.css"
          type="text/css" media="Print"/>
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/beez5.css"
          type="text/css"/>
    <link rel="stylesheet" media="only screen and (max-width: 1023px)" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/max1100.css"
          type="text/css"/>

<!-- other sizes: 1200, 1023, 900, @media handheld, only screen and (max-width: 767px) iphone: @media only screen and (-webkit-min-device-pixel-ratio: 2) -->

    <?php
    $files = JHtml::_('stylesheet', 'templates/' . $this->template . '/css/general.css', null, false, true);
    if ($files):
      if (!is_array($files)):
        $files = array($files);
      endif;
      foreach ($files as $file):
        ?>
        <link rel="stylesheet" href="<?php echo $file;?>" type="text/css"/>
        <?php
      endforeach;
    endif;
    ?>

    <!--[if lte IE 6]>
    <link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/ieonly.css" rel="stylesheet"
          type="text/css"/>
    <![endif]-->
    <!--[if IE 7]>
    <link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/ie7only.css" rel="stylesheet"
          type="text/css"/>
    <![endif]-->
    <?php if ($templateparams->get('html5', 0)) { ?>
    <!--[if lt IE 9]>
    <script type="text/javascript"
            src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/javascript/html5.js"></script>
    <![endif]-->
    <?php } ?>
    <script type="text/javascript"
            src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/javascript/hide.js"></script>

    <script type="text/javascript">
      var big = '<?php echo (int)$this->params->get('wrapperLarge');?>%';
      var small = '<?php echo (int)$this->params->get('wrapperSmall'); ?>%';
      var altopen = '<?php echo JText::_('TPL_BEEZ5_ALTOPEN', true); ?>';
      var altclose = '<?php echo JText::_('TPL_BEEZ5_ALTCLOSE', true); ?>';
      var bildauf = '<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/plus.png';
      var bildzu = '<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/minus.png';
      var rightopen = '<?php echo JText::_('TPL_BEEZ5_TEXTRIGHTOPEN', true); ?>';
      var rightclose = '<?php echo JText::_('TPL_BEEZ5_TEXTRIGHTCLOSE', true); ?>';
      var fontSizeTitle = '<?php echo JText::_('TPL_BEEZ5_FONTSIZE', true); ?>';
      var bigger = '<?php echo JText::_('TPL_BEEZ5_BIGGER', true); ?>';
      var reset = '<?php echo JText::_('TPL_BEEZ5_RESET', true); ?>';
      var smaller = '<?php echo JText::_('TPL_BEEZ5_SMALLER', true); ?>';
      var biggerTitle = '<?php echo JText::_('TPL_BEEZ5_INCREASE_SIZE', true); ?>';
      var resetTitle = '<?php echo JText::_('TPL_BEEZ5_REVERT_STYLES_TO_DEFAULT', true); ?>';
      var smallerTitle = '<?php echo JText::_('TPL_BEEZ5_DECREASE_SIZE', true); ?>';
    </script>
    <?php $this->setTitle('Alliance Publishing Press - the independent publisher for the new publishing era'); ?>

  </head>

    <body id= "<?php echo $pageClass ?>" >
    <!--menu-->
    <div id="top-menu">
      <div id="top-menu-content">
        <jdoc:include type="modules" name="position-1"/>
      </div>
    </div>
    <div id="top-line">
      <div id="top-line-content">
        <?php echo htmlspecialchars($templateparams->get('sitedescription'));?>
      </div>
    </div>

    <div id="all" class = "<?php echo $pageClass ?>">
      <div id="back">


        <header id="header" class = "<?php echo $pageClass ?>">

          <div class="logoheader">

            <div id="logo">
              <?php if ($pageClass != 'home'):  ?>
                <img src="<?php echo $this->baseurl ?>/<?php echo htmlspecialchars($logo); ?>"
                     alt="<?php echo htmlspecialchars($templateparams->get('sitetitle'));?>"/>
              <?php else: ?>
                <img src="images/APP_logo_white-with_horiz_text_transparent.png" alt="<?php echo htmlspecialchars($templateparams->get('sitetitle'));?>"/>
              <?php endif; ?>
            </div>

            <div id="social-links"><jdoc:include type="modules" name="fb-link"/></div>
          </div>
          <!-- end logoheader -->



        </header>
        <!-- end header -->


        <div id="<?php echo $showRightColumn ? 'contentarea2' : 'contentarea'; ?>" class = "<?php echo $pageClass ?> <?php if ($pageClass != 'home') {echo 'showcolumns';} ?>">
          <?php if ($pageClass == 'contact_us'): ?>
            <div class="left1 leftbigger" id='in_touch'>
              <div class="moduletable">
                <h3>Getting in Touch...</h3>
                <p class = 'white_script'> You can contact us by submitting the form on the right or by using the details below.</p>
                </br>
                <strong>Alliance Publishing Press Ltd</strong></br>
                1 Golfside Close</br>
                Whetstone</br>
                London N20 0RD</br>
                United Kingdom</br>
                </br>
                Phone: </br>+44 (0)20 8446 8070</br>
                </br>
                Email: <a href="mailto:enquiries@alliancepublishingpress.com?subject=Enquiry from website">enquiries@alliancepublishingpress.com</a>
              </div>
            </div>
          <?php endif; ?>

          <?php if ($pageClass != 'home' && $pageClass != 'our_services' && $pageClass != 'app_people' && $pageClass != 'cookies_and_your_privacy' && $pageClass != 'contact_us'):  ?>
            <?php if(!$this->params->get('html5', 0)): ?>
                <div class="left1 <?php if ($showRightColumn==NULL){ echo 'leftbigger';} ?>" id="nav">
            <?php else: ?>
                <nav class="left1 <?php if ($showRightColumn==NULL){ echo 'leftbigger';} ?>" id="nav">
            <?php endif; ?>
              <jdoc:include type="modules" name="main-left-menu" style="beezDivision" headerLevel="3" />

            <?php if(!$this->params->get('html5', 0)): ?>
              </div><!-- end navi -->
            <?php else: ?>
              </nav>
            <?php endif; ?>

          <?php endif; ?>




          <div id="<?php echo $showRightColumn ? 'wrapper' : 'wrapper2'; ?>" <?php if (isset($showno)){echo 'class="shownocolumns"';}?>>
            
            <div id="main">

              <?php if ($pageClass != 'home'):  ?>

                <jdoc:include type="message" />
                <jdoc:include type="component" />
              <?php else: ?>
                <div id = "home-columns">
                  <div id="home-left"><jdoc:include type="modules" name="homepage-left" /> </div>
                  <div id="home-right"><jdoc:include type="modules" name="homepage-right" /> </div>
                </div>
              <?php endif; ?>

            </div><!-- end main -->

          </div><!-- end wrapper -->

          <?php if ($pageClass != 'home' && $pageClass != 'our_services' && $pageClass != 'app_people' && $pageClass != 'cookies_and_your_privacy' && $pageClass != 'contact_us'):  ?>
            <div class = 'main-left-bottom'>
              <jdoc:include type="modules" name="main-left-bottom" />
            </div>
          <?php endif; ?>

          <?php if ($showRightColumn) : ?>
            <h2 class="unseen">
              <?php echo JText::_('TPL_BEEZ5_ADDITIONAL_INFORMATION'); ?>
            </h2>
            <div id="close">
              <a href="#" onclick="auf('right')">
      				<span id="bild"><?php echo JText::_('TPL_BEEZ5_TEXTRIGHTCLOSE'); ?></span></a>
            </div>

            <?php if (!$templateparams->get('html5', 0)): ?>
      				<div id="right">
      			<?php else: ?>
      			  <aside id="right">
      			<?php endif; ?>

              <a id="additional"></a>
              <jdoc:include type="modules" name="position-6" style="beezDivision" headerLevel="3"/>
              <jdoc:include type="modules" name="position-8" style="beezDivision" headerLevel="3"  />
              <jdoc:include type="modules" name="position-3" style="beezDivision" headerLevel="3"  />

            <?php if(!$templateparams->get('html5', 0)): ?>
      				</div><!-- end right -->
            <?php else: ?>
              </aside>
            <?php endif; ?>
          <?php endif; ?>



          <div class="wrap"></div>

        </div> <!-- end contentarea -->

      </div>
      <!-- back -->

      <?php if ($showbottom) : ?>
        <div id="footer-inner">

          <div id="bottom">
            <?php if ($this->countModules('position-9')): ?>
              <div class="box box1">
                <jdoc:include type="modules" name="position-9" style="beezDivision" headerlevel="3"/>
              </div>
            <?php endif; ?>

            <?php if ($this->countModules('position-10')): ?>
              <div class="box box2">
                <jdoc:include type="modules" name="position-10" style="beezDivision" headerlevel="3"/>
              </div>
            <?php endif; ?>

            <?php if ($this->countModules('position-11')): ?>
              <div class="box box3">
                <jdoc:include type="modules" name="position-11" style="beezDivision" headerlevel="3"/>
              </div>
            <?php endif; ?>

          </div>
        </div>
      <?php endif; ?>

      <div id="footer-sub">

        <?php if (!$templateparams->get('html5', 0)): ?>
    			<div id="footer">
    		<?php else: ?>
    			<footer id="footer">
    		<?php endif; ?>

        <div id='left-footer'>
          <br /><br />
          Alliance Publishing Press Ltd <br />
          1 Golfside Close, Whetstone, London N20 0RD
          <br />
          <span>Registered in England No. 7741029</span>
        </div>
        <div id='right-footer'>
          <a href='privacy/'>Cookies and your Privacy</a>
          <br /><br />
          <img border="0" title="IPG logo" alt="Independent Publishers Guild logo" src="images/ipg.png">
          <br />
          <span>&copy; 2012 Alliance Publishing Press Ltd</span>
        </div>

        <?php if (!$templateparams->get('html5', 0)): ?>
    			</div><!-- end footer -->
        <?php else: ?>
          </footer>
        <?php endif; ?>

      </div>


    </div>
    <!-- all -->

    <div id="footer-outer">

    </div>
    <!-- <jdoc:include type="modules" name="debug"/> -->
  </body>



  <!-- <?php if ($this->title != 'home'):  ?>
    <?php echo $this->title; ?> <br />
  <?php endif; ?>
  Page class: <?php echo $pageClass; ?>
  <?php var_dump($this); ?> -->

</html>
