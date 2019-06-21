<?php
$teacher = new Teacher();

function loadScript()
{
    echo '<script>
    $(document).ready(function () {
        
        $("#phone_teacher_id").inputmask({mask : "+7(999) 999-99-99", showMaskOnHover: false
        });
        
        $("#email_teacher_id").inputmask({mask: "*{1,16}@*{1,6}[.*{1,3}]", showMaskOnHover: false
        });
        
        $("#address_teacher_id").inputmask({mask: "Aa{0,10} 9{1,3}", showMaskOnHover: false
        });
        
        $("#name_teacher_id").inputmask({mask: "Aa{1,10} Aa{1,10} Aa{1,10}", showMaskOnHover: false
        });
        
        $("table tr").click(function () {

            const id_stroke = $(this).find("td").eq(0).html();
            const name_stroke = $(this).find("td").eq(1).html();
            const spec_stroke = $(this).find("td").eq(2).html();
            const address_stroke = $(this).find("td").eq(3).html();
            const phone_stroke = $(this).find("td").eq(4).html();
            const teacher_email_stroke = $(this).find("td").eq(5).html();
            
            $("input[name=id_teacher]").val(id_stroke);

            $("input[name=name_teacher]").val(name_stroke);

            $("#spec_teacher")[0].value = spec_stroke;

            $("input[name=address_teacher]").val(address_stroke);

            $("input[name=phone_teacher]").val(phone_stroke);
            
            $("input[name=email_teacher]").val(teacher_email_stroke);
            
            $("#change_teacher_id").prop("disabled" , false); 
            $("#del_teacher_id").prop("disabled" , false); 
        });
    });
</script>';
}

;

echo "<table>";
echo "<tr><th style='visibility: hidden'>ID</th><th>Ф.И.О</th><th>Специализация</th><th>Адрес</th><th>Телефон</th><th>Э-майл</th></tr>";

function loadEditor()
{

    if ($_SESSION['user'] == 'admin') {
        echo '<form method="post" name="form1" class="form-main">
	<div class="div-form-main">
		<input style="visibility: hidden; height: 1px" type="text" name="id_teacher" class="box">
		<label for="name_teacher">Ф.И.О.</label>
		<input type="text" pattern="^[А-Яа-яЁё\s]+$" id = "name_teacher_id" name="name_teacher" class="box" required><br>
		<label for="spec_teacher">Специализация</label>
		<select id = "spec_teacher" name="spec_teacher" class="box" required>
		    <option></option>
			<option>Dota 2</option>
			<option>Counter Strike:GO</option>
			<option>Heroes Of The Storm</option>
			<option>StarCraft</option>
		</select>		
		<label for="address_teacher">Адрес</label>
		<input type="text" id = "address_teacher_id" name="address_teacher" class="box" required><br>
		<label for="phone_teacher">Телефон</label>
		<input type="text" name="phone_teacher" id = "phone_teacher_id" class="box" pattern="[^_]{17}" required><br>
		<label for="email_teacher">Э-майл</label>
		<input type="text" name="email_teacher" id="email_teacher_id"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" class="box" required><br>
		<input type="submit" name="add_teacher" value="Добавить" class="button box">
		<input type="submit" id = "change_teacher_id" name="change_teacher" value="Изменить" class="button box" disabled>
		<input type="submit" id = "del_teacher_id" name="del_teacher" value="Удалить" class="button box" formnovalidate disabled>
		<input type="submit" name="search_teacher" value="Поиск" class="button box" formnovalidate>
	</div>
</form>';
    }
}

if (isset($_POST['search_teacher'])) {
    $val_id = $_POST['id_teacher'];
    $val_name = $_POST['name_teacher'];
    $val_spec = $_POST['spec_teacher'];
    $val_address = $_POST['address_teacher'];
    $val_phone = $_POST['phone_teacher'];
    $val_email = strtolower($_POST['email_teacher']);
    $teacher->searchTeacher($val_id, $val_name, $val_spec, $val_address, $val_phone, $val_email);
    loadScript();
    loadEditor();
    return;
}

$teacher->showAllTeacher();

if (isset($_POST['add_teacher'])) {
    $val_name = $_POST['name_teacher'];
    $val_spec = $_POST['spec_teacher'];
    $val_address = $_POST['address_teacher'];
    $val_phone = $_POST['phone_teacher'];
    $val_email = $_POST['email_teacher'];
    $val_login = $teacher->translit($val_name);
    $val_password = $teacher->generator();
    $teacher->addTeacher($val_name, $val_spec, $val_address, $val_phone, $val_login, $val_password, $val_email);
}
if (isset($_POST['del_teacher'])) {
    $val_id = $_POST['id_teacher'];
    $teacher->delTeacher($val_id);
}
if (isset($_POST['change_teacher'])) {
    $val_id = $_POST['id_teacher'];
    $val_name = $_POST['name_teacher'];
    $val_spec = $_POST['spec_teacher'];
    $val_address = $_POST['address_teacher'];
    $val_phone = $_POST['phone_teacher'];
    $val_email = $_POST['email_teacher'];
    $teacher->changeTeacher($val_id, $val_name, $val_spec, $val_address, $val_phone, $val_email);
}

loadEditor();
loadScript();