<?php
$Teams = new Team();

function loadTeamScript()
{
    echo '<script>
    $(document).ready(function(){
        
        $("#team_win_id").inputmask({mask: "9{1,4}", showMaskOnHover: false
        });
        
        $("#team_lose_id").inputmask({mask: "9{1,4}", showMaskOnHover: false
        });
        
        $("table tr").click(function(){

            const team_id_stroke = $(this).find("td").eq(0).html();
            const team_name_stroke = $(this).find("td").eq(2).html();
            const teacher_name_stroke = $(this).find("td").eq(3).html();
            const first_player_stroke = $(this).find("td").eq(4).html();
            const second_player_stroke = $(this).find("td").eq(5).html();
            const third_player_stroke = $(this).find("td").eq(6).html();
            const fourth_player_stroke = $(this).find("td").eq(7).html();
            const fifth_player_stroke = $(this).find("td").eq(8).html();
            const team_win_stroke = $(this).find("td").eq(9).html();
            const team_lose_stroke = $(this).find("td").eq(10).html();
            
    
            $("input[name=team_id").val(team_id_stroke);
    
            $("input[name=team_name]").val(team_name_stroke);
                   
            $("input[name=team_win]").val(team_win_stroke);
            
            $("input[name=team_lose]").val(team_lose_stroke);
               
            $("#teacher_name")[0].value = teacher_name_stroke;
            
            $("#team_first_player")[0].value = first_player_stroke;
    
            $("#team_second_player")[0].value = second_player_stroke;
            
            $("#team_third_player")[0].value = third_player_stroke;
            
            $("#team_fourth_player")[0].value = fourth_player_stroke;
            
            $("#team_fifth_player")[0].value = fifth_player_stroke;
            
            $("#change_Team_id").prop("disabled" , false); 
            $("#del_Team_id").prop("disabled" , false); 
    });
});

    </script>';
}

;


echo "<table>";
echo "<tr><th style='visibility: hidden'>ID</th><th>Дисциплина</th><th>Название</th><th>Куратор</th><th>1 игрок</th><th>2 игрок</th><th>3 игрок</th><th>4 игрок</th><th>5 игрок</th><th>Побед</th><th>Поражений</th><th>Винрейт %</th></tr>";



function loadTeamEditor($Teams)
{
    if ($_SESSION['user'] == 'admin') {
        echo '<form method="post" name="form1" class="form-main">
	    <div class="div-form-main">
		<input style="visibility: hidden; height: 1px" type="text" name="team_id" class="box">
        <label for="team_name">Название</label>
		<input type="text" name="team_name" class="box" required><br>';
        $Teams->selectedTeacherTeamID();
        echo '<label for= "team_first_player">1 игрок</label>';
        echo '<select id = "team_first_player" name="team_first_player" class="box" required>';
        $Teams->selectedStudentNickname();
        echo '<label for= "team_second_player">2 игрок</label>';
        echo '<select id = "team_second_player" name="team_second_player" class="box" required>';
        $Teams->selectedStudentNickname();
        echo '<input style="margin-top: 114px" type="submit" name="add_Team" value="Добавить" class="button box">
		      <input  type="submit" id = "change_Team_id" name="change_Team" value="Изменить" class="button box" disabled>
		</div>
		<div class="div-form-main1">';
        echo '<input style="visibility: hidden; height: 1px" type="text" name="fake" class="box">';
        echo '<label for= "team_third_player">3 игрок</label>';
        echo '<select id = "team_third_player" name="team_third_player" class="box" required>';
        $Teams->selectedStudentNickname();
        echo '<label for= "team_fourth_player">4 игрок</label>';
        echo '<select id = "team_fourth_player" name="team_fourth_player" class="box" required>';
        $Teams->selectedStudentNickname();
        echo '<label for= "team_fifth_player">5 игрок</label>';
        echo '<select id = "team_fifth_player" name="team_fifth_player" class="box" required>';
        $Teams->selectedStudentNickname();
		echo'<label for="team_win">Победы</label>
		<input type="text" id = "team_win_id" name="team_win" class="box" required><br>
		<label for="team_lose">Поражения</label>
		<input type="text" id = "team_lose_id" name="team_lose" class="box" required><br>
		<input type="submit" id = "del_Team_id" name="del_Team" value="Удалить" class="button box" disabled formnovalidate>
		<input type="submit" name="search_Team" value="Поиск" class="button box" formnovalidate>
	</div>
</form>';
    }
};

if (isset($_POST['search_Team'])) {
    $val_teacher_name = $_POST['teacher_name'];
    $val_team_name = $_POST['team_name'];
    $val_first_player = $_POST['team_first_player'];
    $val_second_player = $_POST['team_second_player'];
    $val_third_player = $_POST['team_third_player'];
    $val_fourth_player = $_POST['team_fourth_player'];
    $val_fifth_player = $_POST['team_fifth_player'];
    $val_win = $_POST['team_win'];
    $val_lose = $_POST['team_lose'];
    $Teams->searchTeam($val_team_name,$val_teacher_name, $val_first_player, $val_second_player, $val_third_player, $val_fourth_player, $val_fifth_player, $val_win, $val_lose);
    loadTeamScript();
    loadTeamEditor($Teams);
    return;
}

$Teams->showAllTeams();

if (isset($_POST['add_Team'])) {
    $val_teacher_name = $_POST['teacher_name'];
    $val_team_name = $_POST['team_name'];
    $val_first_player = $_POST['team_first_player'];
    $val_second_player = $_POST['team_second_player'];
    $val_third_player = $_POST['team_third_player'];
    $val_fourth_player = $_POST['team_fourth_player'];
    $val_fifth_player = $_POST['team_fifth_player'];
    $val_win = $_POST['team_win'];
    $val_lose = $_POST['team_lose'];
    $val_winrate = round((100 * $val_win) /($val_win + $val_lose),1);
    $Teams->addTeam($val_team_name,$val_teacher_name, $val_first_player, $val_second_player, $val_third_player, $val_fourth_player, $val_fifth_player, $val_win, $val_lose, $val_winrate);
}
if (isset($_POST['change_Team'])) {
    $val_team_id = $_POST['team_id'];
    $val_teacher_name = $_POST['teacher_name'];
    $val_team_name = $_POST['team_name'];
    $val_first_player = $_POST['team_first_player'];
    $val_second_player = $_POST['team_second_player'];
    $val_third_player = $_POST['team_third_player'];
    $val_fourth_player = $_POST['team_fourth_player'];
    $val_fifth_player = $_POST['team_fifth_player'];
    $val_win = $_POST['team_win'];
    $val_lose = $_POST['team_lose'];
    $val_winrate = round((100 * $val_win) /($val_win + $val_lose),1);
    $Teams->changeTeam($val_team_id, $val_team_name, $val_teacher_name, $val_first_player, $val_second_player, $val_third_player, $val_fourth_player, $val_fifth_player, $val_win, $val_lose, $val_winrate);
}
if (isset($_POST['del_Team'])) {
    $val_team_id = $_POST['team_id'];
    $Teams->delTeam($val_team_id);
}

loadTeamScript();
loadTeamEditor($Teams);

