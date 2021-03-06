<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
    <head>
        <title>EZplayer</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <?php 
        /*
         * EZCAST EZplayer
         *
         * Copyright (C) 2016 Université libre de Bruxelles
         *
         * Written by Michel Jansens <mjansens@ulb.ac.be>
         * 	      Arnaud Wijns <awijns@ulb.ac.be>
         *            Carlos Avidmadjessi
         * UI Design by Julien Di Pietrantonio
         *
         * This software is free software; you can redistribute it and/or
         * modify it under the terms of the GNU Lesser General Public
         * License as published by the Free Software Foundation; either
         * version 3 of the License, or (at your option) any later version.
         *
         * This software is distributed in the hope that it will be useful,
         * but WITHOUT ANY WARRANTY; without even the implied warranty of
         * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
         * Lesser General Public License for more details.
         *
         * You should have received a copy of the GNU Lesser General Public
         * License along with this software; if not, write to the Free Software
         * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
         */ ?>
        <link rel="apple-touch-icon" href="images/ipadIcon.png" /> 
        <link rel="shortcut icon" type="image/ico" href="images/Generale/favicon.ico" />
        <script type="text/javascript" src="js/jQuery/jquery-2.1.3.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="css/ezplayer_style_v2.css" />

        <script type="text/javascript">
            function detect_flash() {
                if ((navigator.mimeTypes ["application/x-shockwave-flash"] == undefined)) {
                    document.form_login.has_flash.value = 'N';
                }
                else {
                    document.form_login.has_flash.value = 'Y';
                }
            }

            function login_server_trace(array) {
                    $.ajax({
                        type: 'POST',
                        url: 'index.php?action=client_trace',
                        data: {info: array}
                    });
                return true;
            }
        </script>
    </head>
    <body>
        <?php
        $warning = true;
        switch (strtolower($_SESSION['browser_name'])) {
            case 'safari' :
                if ($_SESSION['browser_version'] >= 5)
                    $warning = false;
                break;
            case 'chrome' :
                if ($_SESSION['browser_version'] >= 4)
                    $warning = false;
                break;
            case 'internet explorer' :
                if ($_SESSION['browser_version'] >= 9)
                    $warning = false;
                break;
            case 'opera' :
                if ($_SESSION['browser_version'] >= 26)
                    $warning = false;
                break;
            case 'firefox' :
                if (($_SESSION['browser_version'] >= 22 && ($_SESSION['user_os'] == "Windows" || $_SESSION['user_os'] == "Android"))
                        || $_SESSION['browser_version'] >= 35)
                    $warning = false;
                break;
        }
        if ($warning) {
            ?>
            <div id="warning">
                <div>
                    <a href="#" onclick="document.getElementById('warning').style.display = 'none';
                       ">&#215;</a> 
                    ®Warning_browser® :
                    <ul>
                        <li><b>Safari 5+</b> | </li>
                        <li><b>Google Chrome</b> | </li>
                        <li><b>Opera 26+</b> </li>
                        <?php if ($_SESSION['user_os'] == "Windows") { ?>
                            <li><b>Internet Explorer 9+</b> | </li>
                            <li><b>Firefox 22+</b></li>
                        <?php } ?>
                    </ul>
                </div>       
            </div>
        <?php } ?>
        <div class="login_background container">
            <?php include 'div_help_header.php'; ?>
            <div id="global" class="row">
                <form id="form_login" class="form-horizontal col-md-4 col-md-offset-4" style="margin-top: 50px;" method="post" action="<?php
                          global $ezplayer_safe_url;
                          echo $ezplayer_safe_url;
                          ?>/index.php" onsubmit="detect_flash();">
                    
                    <?php if(isset($error)) { ?>
                    <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
                    <?php } ?>
                    
                    <input type="hidden" name="action" value="login" />
                    <input type="hidden" name="has_flash" value=""/>
                    
                    <div class="form-group">
                        <label for="netid" class="col-sm-3 control-label">®Netid®</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="netid" placeholder="NetID" name="login" 
                                   autocapitalize="off" autocorrect="off" tabindex="1">
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="passwd" class="col-sm-3 control-label">®Password®</label>
                      <div class="col-sm-9">
                        <input type="password" class="form-control" name="passwd" placeholder="®Password®"
                               autocapitalize="off" autocorrect="off" tabindex="2">
                      </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <select class="lang form-control" name="lang" tabindex="3" 
                                    onchange="document.location.href = './index.php?lang='+this.value;">
                                <option value="en" <?php if(array_key_exists('lang', $input) && $input['lang'] == 'en') { echo 'selected="selected"'; } ?>>
                                    English
                                </option>
                                <option value="fr" <?php if(!array_key_exists('lang', $input) || $input['lang'] == 'fr') { echo 'selected="selected"'; } ?>>
                                    Français
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-3 col-sm-9">
                        <input type="submit" name="logged_session" class="btn btn-default login" value="®login®" tabindex="4"/>
                      </div>
                    </div>
                </form>
                
                
                <div class="login_video col-md-12">
                    <h2>®tuto_ezplayer®</h2>
                    <video id="tuto_video" width="720" controls="" type="video/mp4" src="./videos/tuto_<?php echo get_lang(); ?>.mp4" style="">
                        ®tuto_ezplayer®</video>
                </div>

            </div>

<?php include 'div_main_footer.php'; ?>

        </div>
    </body>
</html>