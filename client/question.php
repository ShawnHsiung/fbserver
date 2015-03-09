
<script src="./client/js/bootstrap-table.js"></script>

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="glyphicon glyphicon-home"></i> <a href="/fbserver">Home</a>
            </li>
            <li class="active"> Questions</li>
        </ol>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class=" panel panel-primary" id="question-table-new">
                <div class="panel-heading">
                    <h3 class="panel-title">Define New questions</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group ">
                        <div class="alert alert-danger" id="error" style="display: none;" role="alert">
                        </div>
                        <label for="exampleInputFile">Enter your question </label>
                        <input class="form-control" id="question_name"  placeholder="Enter question">
                    </div>           
                    <div class="form-group modal-sm">
                        <label>Select a group to add the question</label>
                        <select class="form-control" id="dropdowngrop">
                        </select>
                    </div>
                </div>
                <div class="panel-footer">
                    <button id="add_question" class="btn btn-primary">Add Question</button>
                </div>
            </div>
                       <br>
                       <br>
        </div>
        
        <div class="col-lg-12">
            <div class=""  id="question_table" >
                <table id="tb_questionlist" data-click-to-select="true" class="table table-bordered table-hover table-striped" data-query-params="queryParams" data-pagination="true">
                    <thead class="bg-primary">
                        <tr>
                            <th data-field="state" data-checkbox="true"></th>
                            <th data-field="context" data-halign="center" data-align="center">Questions</th>
                            <th data-field="name" data-halign="center" data-align="left">Group</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>  
        </div>
    </div>
</div>
<script>
    $('#tb_questionlist').bootstrapTable({});
    //load question_table of this page
    function load_question_table(){
        $.ajax({
                type: "GET",
                url: server_root + "question",
                dataType:"json",
                cache: false,
                success:function (data) {
                    if(!data.error){
                        $('#tb_questionlist').bootstrapTable("load", data.message);
                        return;
                    }else{
                        $('#tb_questionlist').bootstrapTable("load", []);
                    }
                }
            });
    }
    function initDropdown(obj,groub) {
        //default option
        obj.empty();
        obj.append('<option name="-1">select group</option>');
        for(var row in groub ){
            obj.append('<option name=' + groub[row].id + '>' + groub[row].name + '</option>');
        }
    }
    function load_group_list(){
        $.ajax({
             type: "GET",
             url: server_root + "group",
             dataType:"json",
             cache: false,
             success:function (data) {
                 if(!data.error){
                     initDropdown($('#dropdowngrop'),data.message);
                    return;
                }else{
                    initDropdown($('#dropdowngrop'),[]);
                }
             }
         }); 
        
    }
    function add_question(text,name){
        var flag = false;
        $.ajax({
            type: "POST",
            url: server_root + "question",
            dataType:"json",
            cache: false,
            async:false,
            data:{"text":text,"name":name},
            success:function (data) {
                if(!data.error){
                    flag = true;
                }
            }
        }); 
        return flag;
    }
    $(document).ready(function(){
        
        load_question_table();
        load_group_list();
        
        $("#add_question").click(function(){
            var context=$('#question_name').val().trim();
            var groupname = $('#dropdowngrop').val().trim();
            if(!context){
               $("#error").show();
               $("#error").html("Please enter a group name");
               $("#question_name").focus();
                return false;  
            }
            if("select group" === groupname)
            {
                $("#error").show();
                $("#error").html("Please select a group");
                return false;
            }
            if(add_question(context,groupname)){
                load_question_table();
                $('#question_name').val('');
                $('#dropdowngrop').val('');
                $("#question_name").focus();
            }else{
                $("#error").show();
                $("#error").html("Server error, create new question failed!");
                return false;
            }            
            
            
            
            
            return true;
        });
    });
    
</script>
