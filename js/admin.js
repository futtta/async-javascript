/* globals aj_localize_admin,jQuery */
/* eslint no-console: 1 */
// updated:
// 2020-02-01 12:04:00
function notifySettingsSaved() {
  jQuery("#aj_notification").
    fadeIn("slow").
    html('Settings Saved <span class="aj_dismiss"><a title="dismiss this notification">x</a></span>').
    delay(500).
    fadeOut("slow");
}

function log_error(err) {
  if ( err.error ) {
    aj_error = err.error;
  } else {
    aj_error = JSON.stringify(err);
  }
  jQuery('div.aj_loader').replaceWith("<h2 style='color:red'>Error: " + aj_error + "</h2>");
}

function aj_step(theStep) {
  var aj_nonce = jQuery("#aj_nonce").val();
  var aj_gtmetrix_username = jQuery("#aj_gtmetrix_username").val();
  var aj_gtmetrix_api_key = jQuery("#aj_gtmetrix_api_key").val();
  var aj_gtmetrix_server = jQuery("#aj_gtmetrix_server").val();
  var data = {
    action: "aj_steps",
    sub_action: theStep,
    site_url: aj_localize_admin.siteurl,
    aj_gtmetrix_username: aj_gtmetrix_username,
    aj_gtmetrix_api_key: aj_gtmetrix_api_key,
    aj_gtmetrix_server: aj_gtmetrix_server,
    security: aj_nonce
  };
  if (theStep == "aj_step_results") {
    jQuery.post(aj_localize_admin.ajaxurl, data, function(response) {
      try {
        response = jQuery.parseJSON(response);
        if (response.status !== false) {
          var baseline_pagespeed = response.baseline_pagespeed;
          var baseline_yslow = response.baseline_yslow;
          var pagespeed = response.results.pagespeed_score;
          var yslow = response.results.yslow_score;
          var aj_gtmetrix_config = response.name;
          var flt = parseFloat(response.results.fully_loaded_time / 1000).toFixed(2);
          var url = response.url;
          jQuery(".aj_gtmetrix_config").html(aj_gtmetrix_config);
          if (pagespeed > baseline_pagespeed) {
            jQuery("#aj_gtmetrix_inde_pagespeed").html("an increase");
          } else if (pagespeed < baseline_pagespeed) {
            jQuery("#aj_gtmetrix_inde_pagespeed").html("a decrease");
          } else {
            jQuery("#aj_gtmetrix_inde_pagespeed").html("no change");
          }
          if (yslow > baseline_yslow) {
            jQuery("#aj_gtmetrix_inde_yslow").html("an increase");
          } else if (yslow < baseline_yslow) {
            jQuery("#aj_gtmetrix_inde_yslow").html("a decrease");
          } else {
            jQuery("#aj_gtmetrix_inde_yslow").html("no change");
          }
          jQuery("#aj_gtmetrix_baseline_pagespeed").html(baseline_pagespeed + "%");
          jQuery("#aj_gtmetrix_best_pagespeed").html(pagespeed + "%");
          jQuery("#aj_gtmetrix_baseline_yslow").html(baseline_yslow + "%");
          jQuery("#aj_gtmetrix_best_yslow").html(yslow + "%");
          jQuery("#aj_gtmetrix_best_fullyloaded").html(flt + "s");
          jQuery("#aj_gtmetrix_best_url").
            attr("href", url).
            html(url);
          if (response.id == "aj_step2b" || response.id == "aj_step2c") {
            jQuery("#aj_step4_jquery_excluded").hide();
            jQuery("#aj_step4_jquery_not_excluded").show();
          } else if (response.id == "aj_step2d" || response.id == "aj_step2e") {
            jQuery("#aj_step4_jquery_excluded").show();
            jQuery("#aj_step4_jquery_not_excluded").hide();
          }
          jQuery(".aj_gtmetrix_credits").html(response.credits);
          jQuery("#aj_step_results").show();
        } else {
          log_error(response);
        }
      } catch (err) {
        log_error(err);
      }
    });
  } else {
    jQuery.post(aj_localize_admin.ajaxurl, data, function(response) {
      try {
        response = jQuery.parseJSON(response);
        if (response.status !== false) {
          var screenshot = response.results.report_url + "/screenshot.jpg";
          var pagespeed = response.results.pagespeed_score;
          var yslow = response.results.yslow_score;
          var flt = parseFloat(response.results.fully_loaded_time / 1000).toFixed(2);
          var tps = Math.floor(response.results.page_bytes / 1024);
          if (tps > 1024) {
            tps = tps / 1024 + "MB";
          } else {
            tps = tps + "KB";
          }
          var requests = response.results.page_elements;
          var report =
            '<a href="' +
            response.results.report_url +
            '" target="_blank">' +
            response.results.report_url +
            "</a>";
          var report_url = report.replace(
            "https://",
            "https://" + aj_gtmetrix_username + ":" + aj_gtmetrix_api_key + "@"
          );
          var step_name = response.name;
          var step_url = response.url;
          var pr = 255 * (1 - pagespeed / 100);
          var yr = 255 * (1 - yslow / 100);
          var pg = 255 * (pagespeed / 100);
          var yg = 255 * (yslow / 100);
          var prgb = "rgb(" + Math.floor(pr) + "," + Math.floor(pg) + ",0 )";
          var yrgb = "rgb(" + Math.floor(yr) + "," + Math.floor(yg) + ",0 )";
          if (theStep == "aj_gtmetrix_test") {
            theStep = "aj_latest";
          }
          jQuery("#" + theStep + "_please_wait").hide();
          jQuery("." + theStep + "_screenshot").attr("src", screenshot);
          jQuery("." + theStep + "_pagespeed").
            html(pagespeed + "%").
            css({ color: prgb });
          jQuery("." + theStep + "_yslow").
            html(yslow + "%").
            css({ color: yrgb });
          jQuery("." + theStep + "_flt").html(flt + "s");
          jQuery("." + theStep + "_tps").html(tps);
          jQuery("." + theStep + "_requests").html(requests);
          jQuery("." + theStep + "_report").html(report_url);
          jQuery("#" + theStep + "_gtmetrix_results").show();
          jQuery("." + theStep + "_gtmetrix").html(step_name);
          jQuery("." + theStep + "_url").
            attr("href", step_url).
            html(step_url);
          jQuery(".aj_gtmetrix_credits").html(response.credits);
          if (theStep == "aj_step2") {
            notifySettingsSaved();
            jQuery("#aj_step2b").show();
            jQuery("html, body").animate(
              {
                scrollTop: jQuery("#aj_step2b").offset().top
              },
              1000
            );
            aj_step("aj_step2b");
          } else if (theStep == "aj_step2b") {
            jQuery("#aj_step2c").show();
            jQuery("html, body").animate(
              {
                scrollTop: jQuery("#aj_step2c").offset().top
              },
              1000
            );
            aj_step("aj_step2c");
          } else if (theStep == "aj_step2c") {
            jQuery("#aj_step2d").show();
            jQuery("html, body").animate(
              {
                scrollTop: jQuery("#aj_step2d").offset().top
              },
              1000
            );
            aj_step("aj_step2d");
          } else if (theStep == "aj_step2d") {
            jQuery("#aj_step2e").show();
            jQuery("html, body").animate(
              {
                scrollTop: jQuery("#aj_step2e").offset().top
              },
              1000
            );
            aj_step("aj_step2e");
          } else if (theStep == "aj_step2e") {
            jQuery("#aj_step_results").show();
            jQuery("html, body").animate(
              {
                scrollTop: jQuery("#aj_step_results").offset().top
              },
              1000
            );
            aj_step("aj_step_results");
          } else if (theStep == "aj_latest") {
            notifySettingsSaved();
            jQuery("#aj_latest_gtmetrix_results").show();
            jQuery("#aj_latest_please_wait").hide();
            jQuery("html, body").animate(
              {
                scrollTop: jQuery("#aj_latest_please_wait").offset().top
              },
              1000
            );
          }
        } else {
          log_error(response);
        }
      } catch (err) {
        log_error(err);
      }
    });
  }
}

/**
 *    functions and actions to load after document ready
 */
jQuery(document).ready(function() {
  if (typeof jQuery(".aj_chosen").chosen === "function") {
    jQuery(".aj_chosen").chosen();
  }

  jQuery( "#aj_enabled" ).change(function() {
    if (this.checked) {
      jQuery(".aj_enabled_sub").show("slow");
    } else {
      jQuery(".aj_enabled_sub:visible").hide("slow");;
    }
  });

  jQuery(document).on("click", ".aj_steps_button", function(e) {
    e.preventDefault();
    var aj_nonce = jQuery("#aj_nonce").val();
    var theStep = jQuery(this).attr("data-id");
    var settings = theStep.replace("_apply", "");
    var aj_enabled = 1;
    if (theStep == "aj_goto_settings") {
      var newURL = aj_localize_admin.ajadminurl + "&tab=settings";
      window.location.href = newURL;
    } else if (
      theStep == "aj_apply_settings" ||
      theStep == "aj_step2b_apply" ||
      theStep == "aj_step2c_apply" ||
      theStep == "aj_step2d_apply" ||
      theStep == "aj_step2e_apply"
    ) {
      if (theStep != "aj_apply_settings") {
        settings = theStep.replace("_apply", "");
      } else {
        settings = "";
        notifySettingsSaved();
      }
      var data = {
        action: "aj_steps",
        sub_action: "aj_apply_settings",
        settings: settings,
        site_url: aj_localize_admin.siteurl,
        security: aj_nonce
      };
      jQuery.post(aj_localize_admin.ajaxurl, data, function(response) {
        try {
          response = jQuery.parseJSON(response);
          if (response.status !== false) {
            if (jQuery("#aj_step4").length) {
              jQuery("#aj_step5").show();
              jQuery("html, body").animate(
                {
                  scrollTop: jQuery("#aj_step5").offset().top
                },
                1000
              );
              if (settings != "") {
                notifySettingsSaved();
              }
            } else {
              if (settings != "") {
                notifySettingsSaved();
                var newURL = aj_localize_admin.ajadminurl + "&tab=settings";
                window.location.href = newURL;
              }
            }
          } else {
            console.log(response);
          }
        } catch (err) {
          console.log(err);
        }
      });
    } else if (theStep == "aj_save_settings") {
      if (jQuery("#aj_enabled").is(":checked")) {
        aj_enabled = 1;
      } else {
        aj_enabled = 0;
      }
      if (jQuery("#aj_enabled_logged").is(":checked")) {
        aj_enabled_logged = 1;
      } else {
        aj_enabled_logged = 0;
      }
      if (jQuery("#aj_enabled_shop").is(":checked")) {
        aj_enabled_shop = 1;
      } else {
        aj_enabled_shop = 0;
      }
      var aj_method = jQuery("input[type=radio][name=aj_method]:checked").val();
      var aj_jquery = jQuery("input[type=radio][name=aj_jquery]:checked").val();
      var aj_async = jQuery("#aj_async").val();
      var aj_defer = jQuery("#aj_defer").val();
      var aj_exclusions = jQuery("#aj_exclusions").val();
      var aj_plugin_exclusions = jQuery("#aj_plugin_exclusions").
        chosen().
        val();
      var aj_theme_exclusions = jQuery("#aj_theme_exclusions").
        chosen().
        val();
      var aj_autoptimize_enabled = 1;
      var aj_autoptimize_method = jQuery("input[type=radio][name=aj_autoptimize_method]:checked").val();

      if (typeof jQuery(".aj_chosen").chosen === "function") {
        aj_plugin_exclusions = jQuery("#aj_plugin_exclusions").
          chosen().
          val();
        aj_theme_exclusions = jQuery("#aj_theme_exclusions").
          chosen().
          val();
      } else {
        aj_plugin_exclusions = jQuery("#aj_plugin_exclusions").val();
        aj_theme_exclusions = jQuery("#aj_theme_exclusions").val();
      }

      if (jQuery("#aj_autoptimize_enabled").is(":visible")) {
        if (jQuery("#aj_autoptimize_enabled").is(":checked")) {
          aj_autoptimize_enabled = 1;
          aj_autoptimize_method = jQuery("input[type=radio][name=aj_autoptimize_method]:checked").val();
        } else {
          aj_autoptimize_enabled = 0;
          aj_autoptimize_method = jQuery("input[type=radio][name=aj_autoptimize_method]:checked").val();
        }
      } else {
        aj_autoptimize_enabled = 0;
        aj_autoptimize_method = "async";
      }
      var dataSteps = {
        action: "aj_steps",
        sub_action: "aj_save_settings",
        aj_enabled: aj_enabled,
        aj_enabled_logged: aj_enabled_logged,
        aj_enabled_shop: aj_enabled_shop,
        aj_method: aj_method,
        aj_jquery: aj_jquery,
        aj_async: aj_async,
        aj_defer: aj_defer,
        aj_exclusions: aj_exclusions,
        aj_plugin_exclusions: aj_plugin_exclusions,
        aj_theme_exclusions: aj_theme_exclusions,
        aj_autoptimize_enabled: aj_autoptimize_enabled,
        aj_autoptimize_method: aj_autoptimize_method,
        security: aj_nonce
      };
      jQuery.post(aj_localize_admin.ajaxurl, dataSteps, function(response) {
        try {
          response = jQuery.parseJSON(response);
          if (response.status !== false) {
            notifySettingsSaved();
          } else {
            console.log(response);
          }
        } catch (err) {
          console.log(err);
        }
      });
    } else {
      var aj_gtmetrix_username = jQuery("#aj_gtmetrix_username").val();
      var aj_gtmetrix_api_key = jQuery("#aj_gtmetrix_api_key").val();
      var aj_gtmetrix_server = jQuery("#aj_gtmetrix_server").val();
      var isError = false;
      if (aj_gtmetrix_username == "") {
        jQuery("#aj_gtmetrix_username").addClass("aj_field_error");
        isError = true;
      }
      if (aj_gtmetrix_api_key == "") {
        jQuery("#aj_gtmetrix_api_key").addClass("aj_field_error");
        isError = true;
      }
      if (isError === false) {
        if (theStep != "aj_gtmetrix_test") {
          jQuery(this).hide();
          jQuery("#" + theStep).show();
        } else {
          jQuery("#aj_latest_please_wait").show();
        }
        aj_step(theStep);
      } else {
        return false;
      }
    }
  });

  jQuery(document).on(
    "change",
    "input[type=radio][name=aj_step4_check]",
    function() {
      var aj_nonce = jQuery("#aj_nonce").val();
      var theSelection = jQuery(this).val();
      if (theSelection == "y") {
        jQuery("#aj_step4_y").show();
        jQuery("#aj_step4_n").hide();
      } else {
        jQuery("#aj_step4_n").show();
        jQuery("#aj_step4_y").hide();
      }
    }
  );

  jQuery(document).on("click", ".aj_dismiss", function() {
    var aj_nonce = jQuery("#aj_nonce").val();
    jQuery("#aj_notification").fadeOut("slow");
  });
});
