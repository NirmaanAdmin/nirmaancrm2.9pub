    function editGroup(el) {
        var id = $(el).data('id');
        var name = $(el).data('name');
        var order = $(el).data('order');

        var idDiv = document.createElement('input');
        idDiv.setAttribute('name', 'id');
        idDiv.setAttribute('type', 'hidden');
        idDiv.setAttribute('value', id);

        $("#name").val(name);
        $("#order").val(order);

        $("#name").after(idDiv);
        if ($('#groupModal').is(':hidden')) {
            $('#groupModal').modal({
                show: true
            });
        }
    };