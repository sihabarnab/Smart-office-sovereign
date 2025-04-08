        $(document).ready(function () {

           $('#sele_company').change(function () {

             var id = $(this).val();


             $('#subCategory').find('option').not(':first').remove();


             $.ajax({

                url:'/hrm/bio_data/'+id,
                type:'get',

                dataType:'json',
                error: function(xhr, status, error) {
                  // alert(status);

                  alert(xhr.responseText);
                },

                success:function (response) {

                    var len = 0;

                    if (response.data != null) {

                        len = response.data.length;

                    }


                    if (len>0) {

                        for (var i = 0; i<len; i++) {

                             var id = response.data[i].employee_info_id;

                             var name = response.data[i].employee_name;


                             var option = "<option value='"+id+"'>"+name+"</option>"; 


                             $("#subCategory").append(option);

                        }

                    }

                }

             })

           });

        });


