
<script src="./client/js/bootstrap-table.js"></script>


<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="glyphicon glyphicon-home"></i> <a href="/fbserver">Home</a>
            </li>
            <li class="active"> Groups</li>
        </ol>
    </div>
</div>

<div class="container-fluid">
     <!-- /.row --> 
   <div class="row text-left">
        <div class=" col-lg-10" id="questions">
            <p> <a href="#" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#largeModal">Create New Group</a></p>
            <table id="tb_groups" data-classes="table table-bordered table-hover table-striped" data-query-params="queryParams" data-pagination="true">
                <thead>
                    <tr class="bg-primary">
                        <!--<th data-field="id" data-halign="left" data-align="left">Group Id </th>-->
                        <th data-formatter="runningFormatter" data-halign="center" data-align="center">Index</th>
                        <th data-field="name" data-halign="center" data-align="center">Group Name</th>
                        <th data-field="amount" data-halign="center" data-align="center">Total number of Questions</th>
                        <th data-field="action" data-halign="center" data-align="center" data-formatter="pencilFormatter" data-events="actionEvents">Edit</th>
                        <th data-field="action" data-halign="center" data-align="center" data-formatter="ashbinFormatter" data-events="actionEvents">Delete</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
        
    <div class="modal fade " id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                
                <!--modal head-->
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Add new Record</h4>
                </div>
                <!--modal body-->
                <div class="modal-body">
                    <div class="entry-form" id="new_entry" style="padding-top:0px;">
                        <div class="alert alert-danger" id="error" style="display: none;" role="alert">
                        </div>
                        <div id="new_group">
                            <!--show define new question-->
                            <div class="form-group modal-sm">
                                <p> <input class="form-control" id="new-group-name" required="" placeholder="Enter group Name"> </p>
                                <p> <button type="button" id="define_newques" class="btn btn-primary pull-left">Define New Questions</button></p>
                            </div>
                            <br>
                            <br>
                            <!--create new question-->
                            <div class=" panel panel-primary" style="display:none;" id="question-table-new">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Define New questions</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label for="exampleInputFile">Enter your question </label>
                                        <input class="form-control" id="question_context" required="" placeholder="Enter question">
                                    </div>
<!--                                    <div class="form-group modal-sm">
                                        <label>Select a group to add the question</label>
                                        <select class="form-control" id="grouplist_2">
                                            <option>Select group </option>                                  
                                        </select>
                                   </div>-->
                                </div>
                            </div>
                        </div>
                        <!--<p style="padding-left: 36px;" class=" text-left">OR</p>-->
                        <!--show question table-->
                        <div class="form-group">
                            <p><button type="button" id="add_questions"  class="btn btn-primary">Select existing questions</button></p>
                        </div>
                        <!--table list-->
                        <div class=""  id="question_table" style="display:none;" >
                            <table id="tb_question" data-click-to-select="true" class="table table-bordered table-hover table-striped" data-query-params="queryParams" data-pagination="true">
                                <thead class="bg-primary">
                                    <tr>
                                        <th data-field="state" data-checkbox="true"></th>
                                        <th data-field="context" data-halign="center" data-align="center">Questions</th>
                                        <th data-field="name" data-halign="center" data-align="left">
                                            <select class="form-control" id="grouplist_1" onchange="tbFilter(this)">
<!--                                                <option id="1">Gym Equipment</option>
                                                <option id="2">Gym Service</option>-->
                                            </select>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody  class="searchable">
                                </tbody>
                            </table>
                        </div> 
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                          <button type="button" value="done" id="done" class="btn btn-primary">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
                  <!-- /.row -->
        </div>
              <!-- /.container-fluid -->
    </div>
        <!-- /#page-wrapper -->
</div>

<script>
    $('#tb_groups').bootstrapTable({});
    $('#tb_question').bootstrapTable({});
    var g_groubs = [];
    //init group_table of this page
    function load_group_table(){
        $.ajax({
             type: "GET",
             url: server_root + "group",
             dataType:"json",
             cache: false,
             success:function (data) {
                 if(!data.error){
                  $('#tb_groups').bootstrapTable("load", data.message);
                    g_groubs = data.message;
                    return;
                }else{
                    $('#tb_groups').bootstrapTable("load", []);
                }
             }
         }); 
        
    }
    //load question_table of this page
    function load_question_table(){
        $.ajax({
                type: "GET",
                url: server_root + "question",
                dataType:"json",
                cache: false,
                success:function (data) {
                    if(!data.error){
                        $('#tb_question').bootstrapTable("load", data.message);
                        return;
                    }else{
                        $('#tb_question').bootstrapTable("load", []);
                    }
                }
            });
    }
    function update_question(id,name){
        $.ajax({
            type: "PUT",
            url: server_root + "question",
            dataType:"json",
            cache: false,
            data:{"id":id,"name":name},
            success:function (data) {
                if(!data.error){
                    console.log(data);
                }
            }
        }); 
    }
    window.actionEvents = {
        'click .edit': function (e, value, row, index) {
            alert('You click edit icon, row: ' + JSON.stringify(row));
            console.log(value, row, index);
        },
        'click .remove': function (e, value, row, index) {
            var self = $(this);
                $.ajax({
                type: "DELETE",
                url: server_root + "group/" + row["name"],
                dataType:"json",
                cache: false,
                success:function (data) {
                    if(!data.error){
                        //error may happend
                        self.parents('tr').remove();
                        //g_groubs.splice(g_groubs.indexOf(row),1);
                        $("#tb_groups").bootstrapTable('remove', {
                            "field": 'name',"values": row["name"]
                        });
                        $("#tb_question").bootstrapTable('remove', {
                            "field": 'name',"values": row["name"]
                        });
                        load_group_table();
                    }
                }
            }); 
            
        }
    };
    
    function tbFilter(self){
        var str = self.value.trim();
        if("select group" !== str){
            var rex = new RegExp(str, 'i');
            $('.searchable tr').hide();
            $('.searchable tr').filter(function () {
                var value = $(this).find('td').eq(2).text().toLowerCase();
                return rex.test(value);
            }).show();
        }else{
            $('.searchable tr').show();
        }
        
    }
    
    function initDropdown(obj,groub) {
        //default option
        obj.empty();
        obj.append('<option name="-1">select group</option>');
        for(var row in groub ){
            obj.append('<option name=' + groub[row].id + '>' + groub[row].name + '</option>');
        }
    }
    function queryParams() {
        return {
            type: 'owner',
            sort: 'updated',
            direction: 'desc',
            per_page: 20,
            page: 1
        };
    }
    function runningFormatter(value, row, index) {
        return index+1;
    }
    function pencilFormatter(value, row, index) {
        return '<a class="edit ml10" href="javascript:void(0)" > <span class="glyphicon glyphicon-pencil"></span></a>';
    }
    function ashbinFormatter(value, row, index) {
        return '<a class="remove ml10" href="javascript:void(0)" > <span class="glyphicon glyphicon-trash"></span></a>';
    }
    function cleanModal(){
        $("#error").hide();
        $("#new-group-name").val('');
        $("#question_context").val('');
        $("#tb_question").bootstrapTable('getSelections');
    }
    $(document).ready(function(){
        load_group_table();
        //init create new group modal 
        $('#largeModal').on('shown.bs.modal', function () {
            load_question_table();
            initDropdown($('#grouplist_1'),g_groubs);
        });
        //submit new group
        $("#done").click(function(){
            var count = 0;
            var name = $("#new-group-name").val().trim();
            if(name){
                $.ajax({
                    type: "POST",
                    url: server_root + "group",
                    dataType:"json",
                    data:{"name":name},
                    cache: false,
                    success:function (data) {
                        if(!data.error){
                            var temp = $("#tb_question").bootstrapTable('getSelections');
                            if($("#question_context").val().trim()){
                                count++;
                                add_question($("#question_context").val().trim(),name);
                            }
                            if(temp.length){
                                var len = temp.length;
                                for(var i=0;i<len;i++){
                                    update_question(temp[i].id,name);
                                    count++;
                                }
                            }
                            load_group_table();
                            cleanModal();
                            //g_groubs.push({"name":name,"amount":count});
                            $("#largeModal").modal('hide');
                            
                        }
                    }
                }); 
            }else{
                $("#error").show();
                $("#error").html("Please input group name!");
            }
            
        });
        
        $("#add_questions").click(function(){
            if($("#question_table").is(":visible") == false){
                $("#question_table").show("fast"); 
            }else{
                $("#question_table").fadeOut("fast"); 
            }
        });
        $("#define_newques").click(function(){
            if($("#question-table-new").is(":visible") == false){
                $("#question-table-new").show("fast"); 
            }else{
                $("#question-table-new").fadeOut("fast"); 
            }
        });
    });
    
   
</script>
