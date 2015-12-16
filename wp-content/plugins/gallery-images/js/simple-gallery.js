/*
 jQuery Simple gallery

 Copyright (c) 2012 James Smith (http://loopj.com)

 Licensed under the MIT license (http://mit-license.org/)
*/

var __slice = [].slice,
  __indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

(function($, window) {
  var Simplegallery;
  Simplegallery = (function() {

    function Simplegallery(input, options) {
      var ratio,
        _this = this;
      this.input = input;
      this.defaultOptions = {
        animate: true,
        snapMid: false,
        classPrefix: null,
        classSuffix: null,
        theme: null,
        highlight: false
      };
      this.settings = $.extend({}, this.defaultOptions, options);
      if (this.settings.theme) {
        this.settings.classSuffix = "-" + this.settings.theme;
      }
      this.input.hide();
      this.gallery = jQuery("<div>").addClass("gallery" + (this.settings.classSuffix || "")).css({
        position: "relative",
        userSelect: "none",
        boxSizing: "border-box"
      }).insertBefore(this.input);
      if (this.input.attr("id")) {
        this.gallery.attr("id", this.input.attr("id") + "-gallery");
      }
      this.track = this.createDivElement("track").css({
        width: "100%"
      });
      if (this.settings.highlight) {
        this.highlightTrack = this.createDivElement("highlight-track").css({
          width: "0"
        });
      }
      this.dragger = this.createDivElement("dragger");
      this.gallery.css({
        minHeight: this.dragger.outerHeight(),
        marginLeft: this.dragger.outerWidth() / 2,
        marginRight: this.dragger.outerWidth() / 2
      });
      this.track.css({
        marginTop: this.track.outerHeight() / -2
      });
      if (this.settings.highlight) {
        this.highlightTrack.css({
          marginTop: this.track.outerHeight() / -2
        });
      }
      this.dragger.css({
        marginTop: this.dragger.outerHeight() / -2,
        marginLeft: this.dragger.outerWidth() / -2
      });
      this.track.mousedown(function(e) {
        return _this.trackEvent(e);
      });
      if (this.settings.highlight) {
        this.highlightTrack.mousedown(function(e) {
          return _this.trackEvent(e);
        });
      }
      this.dragger.mousedown(function(e) {
        if (e.which !== 1) {
          return;
        }
        _this.dragging = true;
        _this.dragger.addClass("dragging");
        _this.domDrag(e.pageX, e.pageY);
        return false;
      });
      jQuery("body").mousemove(function(e) {
        if (_this.dragging) {
          _this.domDrag(e.pageX, e.pageY);
          return jQuery("body").css({
            cursor: "pointer"
          });
        }
      }).mouseup(function(e) {
        if (_this.dragging) {
          _this.dragging = false;
          _this.dragger.removeClass("dragging");
          return jQuery("body").css({
            cursor: "auto"
          });
        }
      });
      this.pagePos = 0;
      if (this.input.val() === "") {
        this.value = this.getRange().min;
        this.input.val(this.value);
      } else {
        this.value = this.nearestValidValue(this.input.val());
      }
      this.setgalleryPositionFromValue(this.value);
      ratio = this.valueToRatio(this.value);
      this.input.trigger("gallery:ready", {
        value: this.value,
        ratio: ratio,
        position: ratio * this.gallery.outerWidth(),
        el: this.gallery
      });
    }

    Simplegallery.prototype.createDivElement = function(classname) {
      var item;
      item = jQuery("<div>").addClass(classname).css({
        position: "absolute",
        top: "50%",
        userSelect: "none",
        cursor: "pointer"
      }).appendTo(this.gallery);
      return item;
    };

    Simplegallery.prototype.setRatio = function(ratio) {
      var value;
      ratio = Math.min(1, ratio);
      ratio = Math.max(0, ratio);
      value = this.ratioToValue(ratio);
      this.setgalleryPositionFromValue(value);
      return this.valueChanged(value, ratio, "setRatio");
    };

    Simplegallery.prototype.setValue = function(value) {
      var ratio;
      value = this.nearestValidValue(value);
      ratio = this.valueToRatio(value);
      this.setgalleryPositionFromValue(value);
      return this.valueChanged(value, ratio, "setValue");
    };

    Simplegallery.prototype.trackEvent = function(e) {
      if (e.which !== 1) {
        return;
      }
      this.domDrag(e.pageX, e.pageY, true);
      this.dragging = true;
      return false;
    };

    Simplegallery.prototype.domDrag = function(pageX, pageY, animate) {
      var pagePos, ratio, value;
      if (animate == null) {
        animate = false;
      }
      pagePos = pageX - this.gallery.offset().left;
      pagePos = Math.min(this.gallery.outerWidth(), pagePos);
      pagePos = Math.max(0, pagePos);
      if (this.pagePos !== pagePos) {
        this.pagePos = pagePos;
        ratio = pagePos / this.gallery.outerWidth();
        value = this.ratioToValue(ratio);
        this.valueChanged(value, ratio, "domDrag");
        if (this.settings.snap) {
          return this.setgalleryPositionFromValue(value, animate);
        } else {
          return this.setgalleryPosition(pagePos, animate);
        }
      }
    };

    Simplegallery.prototype.setgalleryPosition = function(position, animate) {
      if (animate == null) {
        animate = false;
      }
      if (animate && this.settings.animate) {
        this.dragger.animate({
          left: position
        }, 200);
        if (this.settings.highlight) {
          return this.highlightTrack.animate({
            width: position
          }, 200);
        }
      } else {
        this.dragger.css({
          left: position
        });
        if (this.settings.highlight) {
          return this.highlightTrack.css({
            width: position
          });
        }
      }
    };

    Simplegallery.prototype.setgalleryPositionFromValue = function(value, animate) {
      var ratio;
      if (animate == null) {
        animate = false;
      }
      ratio = this.valueToRatio(value);
      return this.setgalleryPosition(ratio * this.gallery.outerWidth(), animate);
    };

    Simplegallery.prototype.getRange = function() {
      if (this.settings.allowedValues) {
        return {
          min: Math.min.apply(Math, this.settings.allowedValues),
          max: Math.max.apply(Math, this.settings.allowedValues)
        };
      } else if (this.settings.range) {
        return {
          min: parseFloat(this.settings.range[0]),
          max: parseFloat(this.settings.range[1])
        };
      } else {
        return {
          min: 0,
          max: 1
        };
      }
    };

    Simplegallery.prototype.nearestValidValue = function(rawValue) {
      var closest, maxSteps, range, steps;
      range = this.getRange();
      rawValue = Math.min(range.max, rawValue);
      rawValue = Math.max(range.min, rawValue);
      if (this.settings.allowedValues) {
        closest = null;
        $.each(this.settings.allowedValues, function() {
          if (closest === null || Math.abs(this - rawValue) < Math.abs(closest - rawValue)) {
            return closest = this;
          }
        });
        return closest;
      } else if (this.settings.step) {
        maxSteps = (range.max - range.min) / this.settings.step;
        steps = Math.floor((rawValue - range.min) / this.settings.step);
        if ((rawValue - range.min) % this.settings.step > this.settings.step / 2 && steps < maxSteps) {
          steps += 1;
        }
        return steps * this.settings.step + range.min;
      } else {
        return rawValue;
      }
    };

    Simplegallery.prototype.valueToRatio = function(value) {
      var allowedVal, closest, closestIdx, idx, range, _i, _len, _ref;
      if (this.settings.equalSteps) {
        _ref = this.settings.allowedValues;
        for (idx = _i = 0, _len = _ref.length; _i < _len; idx = ++_i) {
          allowedVal = _ref[idx];
          if (!(typeof closest !== "undefined" && closest !== null) || Math.abs(allowedVal - value) < Math.abs(closest - value)) {
            closest = allowedVal;
            closestIdx = idx;
          }
        }
        if (this.settings.snapMid) {
          return (closestIdx + 0.5) / this.settings.allowedValues.length;
        } else {
          return closestIdx / (this.settings.allowedValues.length - 1);
        }
      } else {
        range = this.getRange();
        return (value - range.min) / (range.max - range.min);
      }
    };

    Simplegallery.prototype.ratioToValue = function(ratio) {
      var idx, range, rawValue, step, steps;
      if (this.settings.equalSteps) {
        steps = this.settings.allowedValues.length;
        step = Math.round(ratio * steps - 0.5);
        idx = Math.min(step, this.settings.allowedValues.length - 1);
        return this.settings.allowedValues[idx];
      } else {
        range = this.getRange();
        rawValue = ratio * (range.max - range.min) + range.min;
        return this.nearestValidValue(rawValue);
      }
    };

    Simplegallery.prototype.valueChanged = function(value, ratio, trigger) {
      var eventData;
      if (value.toString() === this.value.toString()) {
        return;
      }
      this.value = value;
      eventData = {
        value: value,
        ratio: ratio,
        position: ratio * this.gallery.outerWidth(),
        trigger: trigger,
        el: this.gallery
      };
      return this.input.val(value).trigger($.Event("change", eventData)).trigger("gallery:changed", eventData);
    };

    return Simplegallery;

  })();
  $.extend($.fn, {
    simplegallery: function() {
      var params, publicMethods, settingsOrMethod;
      settingsOrMethod = arguments[0], params = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
      publicMethods = ["setRatio", "setValue"];
      return jQuery(this).each(function() {
        var obj, settings;
        if (settingsOrMethod && __indexOf.call(publicMethods, settingsOrMethod) >= 0) {
          obj = jQuery(this).data("gallery-object");
          return obj[settingsOrMethod].apply(obj, params);
        } else {
          settings = settingsOrMethod;
          return jQuery(this).data("gallery-object", new Simplegallery(jQuery(this), settings));
        }
      });
    }
  });
  return jQuery(function() {
    return jQuery("[data-gallery]").each(function() {
      var $el, allowedValues, settings, x;
      $el = jQuery(this);
      settings = {};
      allowedValues = $el.data("gallery-values");
      if (allowedValues) {
        settings.allowedValues = (function() {
          var _i, _len, _ref, _results;
          _ref = allowedValues.split(",");
          _results = [];
          for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            x = _ref[_i];
            _results.push(parseFloat(x));
          }
          return _results;
        })();
      }
      if ($el.data("gallery-range")) {
        settings.range = $el.data("gallery-range").split(",");
      }
      if ($el.data("gallery-step")) {
        settings.step = $el.data("gallery-step");
      }
      settings.snap = $el.data("gallery-snap");
      settings.equalSteps = $el.data("gallery-equal-steps");
      if ($el.data("gallery-theme")) {
        settings.theme = $el.data("gallery-theme");
      }
      if ($el.attr("data-gallery-highlight")) {
        settings.highlight = $el.data("gallery-highlight");
      }
      if ($el.data("gallery-animate") != null) {
        settings.animate = $el.data("gallery-animate");
      }
      return $el.simplegallery(settings);
    });
  });
})(this.jQuery || this.Zepto, this);
