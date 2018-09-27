/**
 cd web/libraries/
 npx webpack -w
 */
var NewGame = {
  value: {
    default_ave_win: null,
    default_ave_draw: null,
    default_ave_loss: null,

    default_diff_win: null,
    default_diff_draw: null,
    default_diff_loss: null,

    default_tags: null,

    default_name_home: null,
    default_name_away: null,
  }
};

/**
 * By input
 */
NewGame.value.default_ave_draw = 4.05;
NewGame.value.default_ave_loss = 1.81;
NewGame.value.default_ave_win = 3.93;
NewGame.value.default_ini_draw = 3.96;
NewGame.value.default_ini_loss = 1.74;
NewGame.value.default_ini_win = 4.19;
NewGame.value.default_name_away = "皇家马德里";
NewGame.value.default_name_home = "塞维利亚";
NewGame.value.default_tags = ["西甲", "西甲"];
NewGame.value.default_diff_win = 0.15;
NewGame.value.default_diff_draw = 0.1;
NewGame.value.default_diff_loss = 0.2;

var pathArg = drupalSettings.path.currentPath.split('/');
if (pathArg[1] == 'game' && pathArg[2] == 'info' ) {

  axios.get(
    'http://localhost:8888/5wan/web/sites/default/files/json/5wan/currentGameList.json',
  )
  .then(
    response => {
      var jsonData = response.data

      if (jsonData[pathArg[3]] != undefined) {
        var row = jsonData[pathArg[3]];
        NewGame.value.default_ave_win  = row['ave_win'];
        NewGame.value.default_ave_draw = row['ave_draw'];
        NewGame.value.default_ave_loss = row['ave_loss'];

        NewGame.value.default_ini_win  = row['ini_win'];
        NewGame.value.default_ini_draw = row['ini_draw'];
        NewGame.value.default_ini_loss = row['ini_loss'];

        NewGame.value.default_name_home = row['name_home'];
        NewGame.value.default_name_away = row['name_away'];
        NewGame.value.default_tags = [row['tags']];

        NewGame.value.default_diff_win = 0.15;
        NewGame.value.default_diff_draw = 0.1;
        NewGame.value.default_diff_loss = 0.2;
      }
      else {
        console.log(5222);
      }
    }
  )
}

module.exports = NewGame

/**
 *

NewGame.value.default_tags = ["英超", "英冠", "英甲", "英乙"];

NewGame.value.default_ave_draw = 6.19;
NewGame.value.default_ave_loss = 1.24;
NewGame.value.default_ave_win = 11.65;
NewGame.value.default_ini_draw = 6.37;
NewGame.value.default_ini_loss = 1.22;
NewGame.value.default_ini_win = 11.36;
NewGame.value.default_name_away = "巴塞罗那";
NewGame.value.default_name_home = "莱加内斯";
NewGame.value.default_tags = ["西甲", "西甲"];
NewGame.value.default_diff_win = 0.05;
NewGame.value.default_diff_draw = 0.1;
NewGame.value.default_diff_loss = 0.2;
















 */
