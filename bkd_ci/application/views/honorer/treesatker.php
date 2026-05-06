<script src="<?php echo base_url(); ?>sximo/jstree/jstree.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>sximo/jstree/themes/default/style.min.css">
<div id="data" class="demo"></div>
<script type="text/javascript">
  $('#data').on('changed.jstree', function(e, data) {
    var i, j, r = [];
    d = [];
    for (i = 0, j = data.selected.length; i < j; i++) {
      r.push(data.instance.get_node(data.selected[i]).id);
    }
    idsatker = r.join(', ');
    $('#SATKER_ID').val(idsatker);
    getsatkerdata(idsatker);
    //alert(idsatker+" "+namasatker);
    //reloadgridx();
    // reloadgrid(r.join(', '));
    //console.log('Selected: ' + r.join(', '));
  }).jstree({
    'core': {
      'data': {
        "url": "<?= site_url('honorer/satker'); ?>",
        'data': function(node) {
          return {
            'id': node.id
          };
        },
        "dataType": "json" // needed only if you do not supply JSON headers
      }
    }

  });

  function getsatkerdata(id) {
    $.ajax({
      type: 'POST',
      url: "<?= site_url('honorer/getsatker'); ?>",
      data: {
        id: id
      },
      dataType: 'html',
      success: function(data) {
        $('#SATKER_NAMA').val(data);
        $('#sximo-modal').modal('toggle');

      }
    });
  }
</script>