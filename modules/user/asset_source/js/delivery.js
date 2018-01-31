$('input[type=radio][name="DeliveryForm[role]"]').change(function() {
    if(this.value){
        $.ajax({
            url: baseUrlWithLanguage+'/user/manage/index/select',
            type:'get',
            data:{'UserSearch[rolesAttribute]':this.value},
            success:function(data)
            {
                $('[name="DeliveryForm[recipients][]"]').html('');
                $.each(data, function(i, user) {
                    $('[name="DeliveryForm[recipients][]"]').append($('<option>').text(user.name).attr('value', user.email+'|'+user.name));
                });
                $('[name="DeliveryForm[recipients][]"] option').prop("selected", "selected");
            }
        });
    }
});