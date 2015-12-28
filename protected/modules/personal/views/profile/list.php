<div class="profileList">
    <div class="row">
        <div class="col-md-12 text-center" style="padding: 50px 0 250px">
            <input class="form-control typeahead" type="text" placeholder="Введи имя пользователя для поиска"
                   style="display: inline-block">
        </div>
    </div>
</div>
<script>
    $(function () {
        $('.typeahead').typeahead({
            style: "width: 50%",
            valueKey: "username",
            remote: '<?php echo $this->createUrl("getJSON") ?>?p=%QUERY',
            template: '{{{html}}}',
            engine: Hogan
        });
    });
</script>