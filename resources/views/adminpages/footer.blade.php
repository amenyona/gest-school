<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>document.write(new Date().getFullYear())</script> © Skote.
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Design & Develop by Themesbrand
                </div>
            </div>
        </div>
    </div>
</footer>
</div>
<!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->
<div class="right-bar">
<div data-simplebar class="h-100">
<div class="rightbar-title d-flex align-items-center px-3 py-4">

    <h5 class="m-0 me-2">Settings</h5>

    <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
        <i class="mdi mdi-close noti-icon"></i>
    </a>
</div>

<!-- Settings -->
<hr class="mt-0" />
<h6 class="text-center mb-0">Choose Layouts</h6>

<div class="p-4">
    <div class="mb-2">
        <img src="assets/images/layouts/layout-1.jpg" class="img-thumbnail" alt="layout images">
    </div>

    <div class="form-check form-switch mb-3">
        <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
        <label class="form-check-label" for="light-mode-switch">Light Mode</label>
    </div>

    <div class="mb-2">
        <img src="assets/images/layouts/layout-2.jpg" class="img-thumbnail" alt="layout images">
    </div>
    <div class="form-check form-switch mb-3">
        <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch">
        <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
    </div>

    <div class="mb-2">
        <img src="assets/images/layouts/layout-3.jpg" class="img-thumbnail" alt="layout images">
    </div>
    <div class="form-check form-switch mb-3">
        <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch">
        <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
    </div>

    <div class="mb-2">
        <img src="assets/images/layouts/layout-4.jpg" class="img-thumbnail" alt="layout images">
    </div>
    <div class="form-check form-switch mb-5">
        <input class="form-check-input theme-choice" type="checkbox" id="dark-rtl-mode-switch">
        <label class="form-check-label" for="dark-rtl-mode-switch">Dark RTL Mode</label>
    </div>


</div>

</div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- JAVASCRIPT -->
<script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>

<script src="{{asset('assets/libs/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('assets/libs/spectrum-colorpicker2/spectrum.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
<script src="{{asset('assets/libs/@chenfengyuan/datepicker/datepicker.min.js')}}"></script>

<!-- form advanced init -->
<script src="{{asset('assets/js/pages/form-advanced.init.js')}}"></script>

<script src="{{asset('assets/js/app.js')}}"></script>
</body>
</html>

<script>

$(document).ready(function(){
    var count1 = 0;
    var compteur = 0; 
    var idAnneeAcademique = 0;

        var matieres = <?php echo json_encode(getMatieres()); ?>;
        var annees = <?php echo json_encode(getAnnees()); ?>;
        var enseignants = <?php echo json_encode(getEnseignants()); ?>;
        var eleves = <?php echo json_encode(getEleveByAnneeAcademique(session()->get('keyanneeAcaCompo'))); ?>;
        var elevesForNote = <?php echo json_encode(getEleveByAnneeAcademiqueForChangementNote(session()->get('keyanneeAcaCompoNote'))); ?>;
        var classes = <?php echo json_encode(getEleveForAnneeAcademique(session()->get('keyanneeAcaCompo'))); ?>;

        $('.ajoutord').click(function(){
        $(".buttonSav").prop('disabled', false);     
        compteur++;
        //alert("ok");
        var html = '';
        html += '<tr id="'+compteur+'">';
            html += '<td><select class="form-control select2 enseignant" data-sub_user_id="'+compteur+'" name="item_enseignant[]" required><option value="Veuillez Sélectionner">Veuillez Sélectionner</option>' + enseignants.map(enseignant => '<option value="'+enseignant.id+'">'+enseignant.name +'   '+enseignant.firstname+'</option>').join('') + '</select></td>';
            html += '<td><select class="form-control select2 matiere" data-sub_user_id="'+compteur+'" name="item_matiere[]" required attrib=""><option value="Veuillez Sélectionner">Veuillez Sélectionner</option>' + matieres.map(matiere => '<option value="'+matiere.id+'">'+matiere.libelleMatiere+'</option>').join('') + '</select></td>';
           html +='<td><button type="button" id="'+compteur+'" name="remoord" class="btn btn-danger btn-xs remoord"><i class="far fa-trash-alt"></i></button></td>';
        
        $('#resultat').append(html); 
       
        })
        $(document).on('click', '.remoord', function(){
        var button_id = $(this).attr("id");
        $("tr#"+button_id).remove();
        compteur--
        //alert(compteur)
        if(compteur <= 0 ){
            $(".buttonSav").prop('disabled', true); 
        }
    });
    /** debut code de la vue rechercherclassepourcomposition*/
    $('.ajoutcompo').click(function(){
        $(".buttoncompo").prop('disabled', false);     
        compteur++;
        //alert("ok");
        var html = '';
            html += '<tr id="'+compteur+'">';
            html += '<td><select id="eleveevaluation" class="form-control select2 eleveevaluation" data-sub_user_id="'+compteur+'" name="item_eleve[]" required><option value="Veuillez Sélectionner">Veuillez Sélectionner</option>' + eleves.map(eleve => '<option value="'+eleve.id+'">'+eleve.name +'   '+eleve.firstname+'</option>').join('') + '</select></td>';
            html += '<td><select class="form-control select2 classe" data-sub_user_id="'+compteur+'" name="item_classe[]" required attrib="" dependente="classe"><option value="Veuillez Sélectionner">Veuillez Sélectionner</option>' + + '</select></td>';
            html += '<td><select class="form-control select2 matieres" data-sub_user_id="'+compteur+'" name="item_matiere[]" required attrib=""><option value="Veuillez Sélectionner">Veuillez Sélectionner</option>' + matieres.map(matiere => '<option value="'+matiere.id+'">'+matiere.libelleMatiere+'</option>').join('') + '</select></td>';
            html += '<td><input type="text" class="form-control"  name="note[]" placeholder="Entrer la note"></td>';
            html += '<td><input type="date" class="form-control"  name="datecompo[]" placeholder="Entrer la date"></td>';
            html += '<td><select class="form-control select2" name="trimestre[]"><option>Veuillez Sélectionner</option><option value="premiertrimestre">Premier trimetsre</option><option value="deuxiemetrimetsre">Deuxième trimestre</option><option value="troisiemetrimestre">Troisième trimestre</option></select></td>';
            html += '<td><select class="form-control select2" name="evaluation[]"><option>Veuillez Sélectionner</option><option value="composition">Composition</option><option value="devoir">Devoir</option></select></td>';
            html +='<td><button type="button" id="'+compteur+'" name="removecompo" class="btn btn-danger btn-xs removecompo"><i class="far fa-trash-alt"></i></button></td>';
        
        $('#composition').append(html); 
       
        })
        $(document).on('click', '.removecompo', function(){
        var button_id = $(this).attr("id");
        $("tr#"+button_id).remove();
        compteur--
        //alert(compteur)
        if(compteur <= 0 ){
            $(".buttoncompo").prop('disabled', true); 
        }
    });
    $('.ajoutsanction').click(function(){
        $(".buttonsanction").prop('disabled', false);     
        compteur++;
        //alert("ok");
        var html = '';
            html += '<tr id="'+compteur+'">';
            html += '<td><select id="eleveevaluation" class="form-control select2 eleveevaluation" data-sub_user_id="'+compteur+'" name="item_eleve[]" required><option value="Veuillez Sélectionner">Veuillez Sélectionner</option>' + elevesForNote.map(eleve => '<option value="'+eleve.id+'">'+eleve.name +'   '+eleve.firstname+'</option>').join('') + '</select></td>';
            html += '<td><select class="form-control select2 classe" data-sub_user_id="'+compteur+'" name="item_classe[]" required attrib="" dependente="classe"><option value="Veuillez Sélectionner">Veuillez Sélectionner</option>' + + '</select></td>';
            html += '<td><select class="form-control select2 matieres" data-sub_user_id="'+compteur+'" name="item_matiere[]" required attrib=""><option value="Veuillez Sélectionner">Veuillez Sélectionner</option>' + matieres.map(matiere => '<option value="'+matiere.id+'">'+matiere.libelleMatiere+'</option>').join('') + '</select></td>';
            html += '<td><input type="text" class="form-control"  name="note[]" placeholder="Entrer la note"></td>';
            html += '<td><textarea id="textarea" name="raison[]" class="form-control" maxlength="225" rows="3" placeholder="This textarea has a limit of 225 chars."></textarea></td>';
            html += '<td><input type="date" class="form-control"  name="datecompo[]" placeholder="Entrer la date"></td>';
            html += '<td><select class="form-control select2" name="trimestre[]"><option>Veuillez Sélectionner</option><option value="premiertrimestre">Premier trimetsre</option><option value="deuxiemetrimetsre">Deuxième trimestre</option><option value="troisiemetrimestre">Troisième trimestre</option></select></td>';
            html += '<td><select class="form-control select2" name="evaluation[]"><option>Veuillez Sélectionner</option><option value="composition">Composition</option><option value="devoir">Devoir</option></select></td>';
            html +='<td><button type="button" id="'+compteur+'" name="removecomposanction" class="btn btn-danger btn-xs removecomposanction"><i class="far fa-trash-alt"></i></button></td>';
        
        $('#compositionsanction').append(html); 
       
        })
        $(document).on('click', '.removecomposanction', function(){
        var button_id = $(this).attr("id");
        $("tr#"+button_id).remove();
        compteur--
        //alert(compteur)
        if(compteur <= 0 ){
            $(".buttonsanction").prop('disabled', true); 
        }
    });
    /** fin code de la vue rechercherclassepourcomposition*/
   var enseignantId = 0
    $(document).on('change', '.enseignant', function() {
    // Code à exécuter lorsqu'une option est sélectionnée
    var selectedValue = $(this).val();  // Récupérer la valeur sélectionnée
    console.log('Option sélectionnée : ' + selectedValue);
     enseignantId  = selectedValue
    console.log(enseignantId)
    var parentRow = $(this).closest('tr');  // Récupérer la ligne parente (<tr>)
    // Attribuer une valeur à `item_prixunitairev[]` basée sur la sélection
    //quantiteField.val(selectedValue);  // Par exemple, utiliser la valeur sélectionnée (vous pouvez la changer)
    // Afficher dans la console pour vérifier
    console.log('Quantité mise à jour avec la valeur : ' + selectedValue)
    var selectedText = $(this).find('option:selected').text();
    $('.enseignant').not(this).each(function(){
        $(this).find('option[value="'+selectedValue+'"]').remove();
    })

    
});

$(document).on('change', '.matiere', function() {
    // Code à exécuter lorsqu'une option est sélectionnée
    var selectedValue = $(this).val();  // Récupérer la valeur sélectionnée
    console.log('Option sélectionnée : ' + selectedValue);
    console.log('qsdsqd'+enseignantId)
    var parentRow = $(this).closest('tr');  // Récupérer la ligne parente (<tr>)
    // Attribuer une valeur à `item_prixunitairev[]` basée sur la sélection
    //quantiteField.val(selectedValue);  // Par exemple, utiliser la valeur sélectionnée (vous pouvez la changer)
    // Afficher dans la console pour vérifier
    console.log('Quantité mise à jour avec la valeur : ' + selectedValue)
    var selectedText = $(this).find('option:selected').text();
    $('.enseignant').not(this).each(function(){
        $(this).find('option[value="'+selectedValue+'"]').remove();
    })
    var enseignant = enseignantId
    var matiere = selectedValue
    $.ajax({
    url: "{{ route('enseignant.verifDoublonv') }}",  // L'URL de la route Laravel
    type: "POST",  // Méthode POST pour envoyer des données
    data: {
        _token: "{{ csrf_token() }}",  // Ajout du token CSRF pour la protection
        matiere: matiere,  // La valeur envoyée au serveur
    },
    success: function(response) {
        // Traiter la réponse du serveur
        //console.log(response.prix);
      
        console.log('okokookk')
             
        // Vous pouvez mettre à jour votre interface avec les données reçues
    },
    error: function(xhr, status, error) {
        // Gérer les erreurs
        console.error('Erreur : ' + error);
    }
});
});
$('.dynamique').change(function(){
            
            if($(this).val()!=''){
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent  = $('.eleve').attr('dependente');
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url : "{{route('auth.fetch')}}",
                    method : "POST",
                    data:{select:select, value:value, _token:_token,dependent:dependent},
                    
                    success:function(result){
                        $('.eleve').html(result)
                    }

                    })
            }
        });
$('.dynamiq').change(function(){
            
            if($(this).val()!=''){
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent  = $('.eleve').attr('dependente');
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url : "{{route('auth.fetch')}}",
                    method : "POST",
                    data:{select:select, value:value, _token:_token,dependent:dependent},
                    
                    success:function(result){
                        $('.eleve').html(result)
                    }

                    })
            }
        });
$('.dynamic').change(function(){
            
            if($(this).val()!=''){
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent  = $('.classee').attr('dependente');
                var _token = $('input[name="_token"]').val();
                idAnneeAcademique = value;
                $.ajax({
                    url : "{{route('auth.fetchClassesForAnnee')}}",
                    method : "POST",
                    data:{select:select, value:value, _token:_token,dependent:dependent},
                    
                    success:function(result){
                        $('.classee').html(result)
                    }

                    })
            }
        });
$('.classee').change(function(){
            
    /*var value = $(this).val();
    alert(value)*/

    if($(this).val()!=''){
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent  = $('.classes').attr('dependente');
                var _token = $('input[name="_token"]').val();
                var idAnnee = idAnneeAcademique;
                $.ajax({
                    url : "{{route('auth.fetchClassesScolariteForAnnee')}}",
                    method : "POST",
                    data:{select:select, value:value, _token:_token,dependent:dependent, idAnnee:idAnnee},
                    
                    success:function(result){
                        $('input[name="montantTotalpaye"]').val(result[0].scolarite)
                        
                    }

                    })
            }
        });

$('.tuteurparentinscrip').change(function(){
            
    /*var value = $(this).val();
    alert(value)*/

    if($(this).val()!=''){
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent  = $('.classes').attr('dependente');
                var _token = $('input[name="_token"]').val();
                var idAnnee = idAnneeAcademique;
                $.ajax({
                    url : "{{route('auth.fetchTuteurEmailAndTel')}}",
                    method : "POST",
                    data:{select:select, value:value, _token:_token,dependent:dependent, idAnnee:idAnnee},
                    
                    success:function(result){
                        console.log(result.phone)
                        $('input[name="phoneeleve"]').val(result.phone)                        
                    }

                    })
            }
        });
        
        $(document).on('change', '.eleveevaluation', function() {
                    
            if($(this).val()!=''){
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent  = $('.classe').attr('dependente');
                var _token = $('input[name="_token"]').val();
                idAnneeAcademique = value;
                var currentRow = $(this).closest('tr');
                var selectedText = $(this).find('option:selected').text();
                $('.eleveevaluation').not(this).each(function(){
                    $(this).find('option[value="'+value+'"]').remove();
                })
                $.ajax({
                    url : "{{route('composition.fetchClassesForAnnee')}}",
                    method : "POST",
                    data:{select:select, value:value, _token:_token,dependent:dependent},
                    
                    success:function(result){
                        const select2 = currentRow.find('.classe');
                        select2.empty();
                        //console.log(result)
                        result.forEach(function(option) {
                        select2.append(`<option value="${option.id}">${option.nom}</option>`);
                      });
                        //$('.classe').html(result)
                       }

                    })
            }
        
         
                
        });

        $('.eleveeditevaluation').change(function(){
            
            //var value = $(this).val();
            //alert(value)
            if($(this).val()!=''){
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent  = $('.classeEvaluation').attr('dependente');
                var _token = $('input[name="_token"]').val();
                idAnneeAcademique = value;
                $.ajax({
                    url : "{{route('composition.fetchClassesForEleve')}}",
                    method : "POST",
                    data:{select:select, value:value, _token:_token,dependent:dependent},
                    
                    success:function(result){
                        $('.classeEvaluation').html(result)
                    }

                    })
            }
           
                });
       
});



/*})*/

</script>
