<?php
$data = include __DIR__.'/data.php';
shuffle($data);
function match($c1, $c2)
{
	//В среднем сколько матчей выигрывали Команда 1 и Команда 2
	$average_win1 = $c1['games'] ? $c1['win'] / $c1['games'] : 0;
	$average_win2 = $c2['games'] ? $c2['win'] / $c2['games'] : 0;

	//В среднем сколько матчей проигрывали Команда 1 и Команда 2
	$average_defeat1 = $c1['games'] ? $c1['defeat'] / $c1['games'] : 0;
	$average_defeat2 = $c2['games'] ? $c2['defeat'] / $c2['games'] : 0;

	//В среднем сколько матчей играли в ничью Команда 1 и Команда 2
	$average_draw1 = $c1['games'] ? $c1['draw'] / $c1['games'] : 0;
	$average_draw2 = $c2['games'] ? $c2['draw'] / $c2['games'] : 0;

	//Получаем рейтинг нападения. Получить средний показатель забитых голов (Команда 1 и Команда 2)
	$average_scored1 = $c1['games'] ? $c1['goals']['scored'] / $c1['games'] : 0;
	$average_scored2 = $c2['games'] ? $c2['goals']['scored'] / $c2['games'] : 0;

	//Получаем рейтинг защиты. Получить средний показатель пропущенных голов (Команда 1 и Команда 2)
	$average_skiped1 = $c1['games'] ? $c1['goals']['skiped'] / $c1['games']: 0;
	$average_skiped2 = $c2['games'] ? $c2['goals']['skiped'] / $c2['games'] : 0;

	// Команда 1: Вероятность что будут забыты
	$score1 = ($average_scored1 + $average_skiped2) / 2;
	
	// Команда 2 Вероятность что будут забыты
	$score2 = ($average_scored2 + $average_skiped1) / 2;
	
	/**
	 * Теперь можно округлять учитывая коэффициенты выигрышей,
	 * проигрышей и ничейных результатов.
	 * Чисто мой подход.
	 */
	 // Команда 1: Вероятность выгрыша
	 $score_win1 = ($average_win1 + $average_draw1 + $average_defeat2) / 3;
	 // Команда 2: Вероятность выгрыша
	 $score_win2 = ($average_win2 + $average_draw2 + $average_defeat1) / 3;

	 if($score_win1 > $score_win2)
	 {
		$score1 = ceil($score1 + $score_win1);
		$score2 = floor($score2 + $score_win2);
	 } elseif($score_win1 < $score_win2) {
		$score1 = floor($score1 + $score_win1);
		$score2 = ceil($score2 + $score_win2);
	 } else {
		$score1 = round($score1 + $score_win1);
		$score2 = round($score2 + $score_win2);
	 }

	return [
		$score1,
		$score2
	];
	
}

$res = match($data[0], $data[1]);
echo $data[0]['name'] .' - '.$data[1]['name'].'<br>';
echo implode('-',$res);



