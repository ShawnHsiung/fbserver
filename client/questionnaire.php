<script src="./client/js/bootstrap-table.js"></script>


<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="glyphicon glyphicon-home"></i> <a href="/fbserver">Home</a>
            </li>
            <li class="active"> Questionnaire</li>
        </ol>
    </div>
</div>

<div class="container-fluid">
     <!-- /.row --> 
   <div class="row">
        <div class="col-lg-10">
            <div class=" panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Active Group</h3>
                </div>
                <div class="panel-body">
                    <div class="alert alert-danger" id="info" style="display: none;" role="alert">
                    </div>
                    <table id="questionnaire" data-classes="table table-bordered table-hover table-striped" data-query-params="queryParams" data-pagination="true">
                        <thead>
                            <tr class="bg-primary">
                                <th data-formatter="runningFormatter" data-halign="center" data-align="center" >Index</th>
                                <th data-field="context" data-halign="center" data-align="center">
                                    Question
                                </th>
                                <th data-field="name" data-halign="center" data-align="center">
                                    Group
                                </th>
                                <th data-field="action" data-halign="center" data-align="center" data-formatter="removeFormatter" data-events="actionEvents">
                                    Remove
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <p>
                        <button id="additem" class="btn btn-lg btn-primary">Append</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#questionnaire').bootstrapTable({});
   
    //load questionnaire
    function load_questionnaire_table(){
        $.ajax({
                type: "GET",
                url: server_root + "questionnaire",
                dataType:"json",
                cache: false,
                success:function (data) {
                    if(!data.error){
                        $('#questionnaire').bootstrapTable("load", data.message);
                        return;
                    }else{
                        $('#questionnaire').bootstrapTable("load", []);
                    }
                }
            });
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
    function removeFormatter(value, row, index) {
        return '<a class="remove ml10" href="javascript:void(0)" > <span class="glyphicon glyphicon-remove"></span></a>';
    }
    window.actionEvents = {
        'click .remove': function (e, value, row, index) {
//            var self = $(this);
            $.ajax({
                type: "DELETE",
                url: server_root + "questionnaire/" + row["id"],
                dataType:"json",
                cache: false,
                success:function (data) {
                    if(!data.error){
                        load_questionnaire_table();
                    }
                }
            }); 
        }
    };
    
    $(document).ready(function(){
        load_questionnaire_table();
        $("#additem").click(function(){
            var len = $('#questionnaire').bootstrapTable('getData').length;
            customRow(len+1);
            ajaxloadgroup();
            this.disabled = true;
        });
    });
    function customRow(len){
        var group_str = '<select class="form-control" id="groups" onchange="quesfiletr(this)"></select>';
        var depend_group_str = '<select class="form-control" id="questions" onchange="queschange(this)"></select>';
        $('#questionnaire > tbody:last').append('<tr><td align="center">' + len + '</td><td>' +
                depend_group_str + '</td><td>' + 
                group_str + '</td><td align="center" ><a class="edit ml10" href="javascript:void(0)" onclick="addtoactive(this)" > <span class="glyphicon glyphicon-floppy-disk"></span></a></td></tr>');
    }
    function initSelectGroup(obj,groub) {
        obj.empty();
        obj.append('<option name=-1>--Select--</option>');
        var len = groub.length;
        for(var i=0;i<len;i++ ){
            obj.append('<option name=' + groub[i].id + '>' + groub[i].name + '</option>');
        }
    }
    function initSelectQues(obj,ques) {
        obj.empty();
        obj.append('<option name=-1>--Select--</option>');
        var len = ques.length;
        for(var i=0;i<len;i++ ){
            obj.append('<option name=' + ques[i].id + '>' + ques[i].context + '</option>');
        }
    }
    function ajaxloadgroup(){
        $.ajax({
            type: "GET",
            url: server_root + "group",
            dataType:"json",
            success:function (data) {
                if(!data.error){
                    initSelectGroup($("#groups"),data.message);
                   return;
               }else{
                   initSelectGroup($(self),[]);
               }
            }
        }); 
    }
    function quesfiletr(self){
        var str = self.value.trim();
        if("--Select--" !== str){
            ajaxloadquestion(str);
        }
    }
    function queschange(self){
        var str = self.value.trim();
        if("--Select--" !== str){
            $("#info").hide();
        }
    }
    
    function ajaxloadquestion(name){
        $.ajax({
            type: "GET",
            url: server_root + "question/" + name,
            dataType:"json",
            cache: false,
            success:function (data) {
                if(!data.error){
                    initSelectQues($("#questions"),data.message);
                    return;
                }else{
                    initSelectQues($("#questions"),[]);
                }
            }
        });
    }
    function addtoactive(self){
        var obj = $(self).parents('tr').find('td').eq(1).find('select');
        var id = $('option:selected', obj).attr('name');
        if(id){
            insertActive(id);
            $("#additem").disable = false;
        }else{
            $("#info").html('Please select question！');
            $("#info").show();
        }
    }
    
    function insertActive(id){
        $.ajax({
            type: "POST",
            url: server_root + "questionnaire",
            dataType:"json",
            data:{"id":id},
            cache: false,
            success:function (data) {
                if(!data.error){
                    load_questionnaire_table();
                    return;
                }else{
                    
                }
            }
        });
    }
</script>

<!--function questionFormatter(value, row, index) {
        var pre_str = '<select disabled class="form-control" id="question">';
        var las_str = '</select>';
        var options = row['context'];
        var len = options.length;
        for(var i=0;i<len;i++){
            pre_str = pre_str + '<option> ' + options[i].context + '</option>'
        }
        return pre_str + las_str;
        
    }
    function groupFormatter(value, row, index) {
        var pre_str = '<select disabled class="form-control" id="question" onchange="tbFilter(this)">';
        var las_str = '</select>';
        var options = row['name'];
        var len = options.length;
        for(var i=0;i<len;i++){
            pre_str = pre_str + '<option>' + options[i].name + '</option>'
        }
        return pre_str + las_str;
    }-->