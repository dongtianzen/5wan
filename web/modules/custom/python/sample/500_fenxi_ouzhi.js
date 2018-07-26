
(function(window){
  var _target = window,
    _offsetTop = 0,
    _notLoading = true,
    _limit = 30,
    _start = _limit,
    _r = 1,
    _id = 523156,
    _ctype = 1,
    _style = 0;
  window._total = 276;
  window._notLoaded = true;
  function bindEvent(t,e,f){
    if (t.attachEvent) {
      t.attachEvent('on'+e, f);
    } else if (t.addEventListener) {
      t.addEventListener(e,f,false);
    }
  }
  $(document).ready(function(){
    bindEvent(_target, 'scroll', function(){
      if (_notLoaded && _notLoading) {
        if ($('#step_line').offset().top + _offsetTop < 810 + $(_target.document).scrollTop() + _target.document.documentElement.clientHeight) {
          _notLoading = false;
          $('#step_loading').html('正在动态加载');
          var _guojia = $("#guojia").attr("checked")?1:0,
            _chupan = $("#op_chupan").attr("checked")?1:0;
          $.get('/fenxi1/ouzhi.php',{id:_id,ctype:_ctype,start:_start,r:_r,style:_style,guojia:_guojia,chupan:_chupan},function(data){
            if (data=='') {
              _notLoaded = false;
              $('#step_line').remove();
            } else {
              $('#step_line').replaceWith(data+'<tr id="step_line" class="step_line"><td id="step_loading" colspan="15">等待动态加载</td></tr>');
              _notLoading = true;
              //setOddsClick(_start);
              _start += _limit;
                        }
          });
        }
      }
    });
  });
  window.oddsLoadAll = function(){
    if (_notLoaded !== false) {
      if (_notLoaded === 0) {
        showOddsAll();
        return;
      }
      _notLoading = false;
      $('#step_loading').html('正在动态加载');
      setTimeout(function(){
        var _guojia = $("#guojia").attr("checked")?1:0,
          _chupan = $("#op_chupan").attr("checked")?1:0;
        $.ajax({
          url:'/fenxi1/ouzhi.php',
          async:false,
          data:{id:_id,ctype:_ctype,start:_start,r:_r,style:_style,last:1,guojia:_guojia,chupan:_chupan},
          success:function(data){
            $('#step_line').replaceWith(data);
            _start += _limit;
            _notLoaded = false;
                    }
        });
      },10);
    }
  };
})(window);
