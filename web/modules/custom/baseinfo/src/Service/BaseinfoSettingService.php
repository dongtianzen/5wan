<?php

/**
 * @file
 * Contains Drupal\baseinfo\Service\BaseinfoSettingService.php.
 */
namespace Drupal\baseinfo\Service;

use Drupal\flexinfo\Service\FlexinfoSettingService;

/**
 * An example Service container.
 */
class BaseinfoSettingService extends FlexinfoSettingService {

  /**
   * use Drupal\Component\Utility\Xss;
   *
   * @return parent::adminTag() + custom tags
   *
   * \Drupal::getContainer()->get('baseinfo.setting.service')->baseAdminTag();
   */
  public function baseAdminTag() {
    $admin_tags_plus = [
      'router-link',
      'router-view',
    ];

    $admin_tags = array_merge($admin_tags_plus, $this->adminTag());

    return $admin_tags;
  }

  /**
   * @param $pound_sign (#)
   * $legends = \Drupal::getContainer()->get('baseinfo.setting.service')->colorPlateOne();
   */
  public function colorPlateOne($key = NULL, $pound_sign = FALSE) {
    $plate_array = array(
      '1' => 'd6006e',
      '2' => '7dba00',
      '3' => '0093d0',
      '4' => '4a245e',
      '5' => '',
      '6' => '',
      '7' => '',
      '8' => '',
    );

    $output = $this->colorPlateOutput($plate_array, $key, $pound_sign, 'f6f6f6');
    return $output;
  }

  public function colorPlatePieChartEventPage($key = NULL, $pound_sign = FALSE) {
    $plate_array = array(
      '1' => 'f24b99',
      '2' => 'f7d417',
      '3' => 'c6c6c6',
      '4' => '05d23e',
      '5' => '2fa9e0',     // 5
      '6' => '75d1e0',
      '7' => '05d23e',     // 7
      '8' => 'ef1a9d',
      '9' => 'bfbfbf',
    );

    $output = $this->colorPlateOutput($plate_array, $key, $pound_sign, 'f6f6f6');
    return $output;
  }

  public function colorPlatePieChartEventPagePlus($key = NULL, $pound_sign = FALSE) {
    $color_array = $this->colorPlatePieChartEventPage();
    $plate_array[1] = 'bfbfbf';

    for ($i = 1; $i < 9; $i++) {
      $plate_array[$i + 1] = $color_array[$i];
    }

    $output = $this->colorPlateOutput($plate_array, $key, $pound_sign, 'f6f6f6');
    return $output;
  }

  public function colorPlateThree($key = NULL, $pound_sign = FALSE) {
    $plate_array = array(
      '1' => '2fa9e0',  // yes
      '2' => 'f24b99',  // no
      '3' => 'c6c6c6',  // will consider
    );

    $output = $this->colorPlateOutput($plate_array, $key, $pound_sign, 'f6f6f6');
    return $output;
  }

  public function colorPlateThreePlus($key = NULL, $pound_sign = FALSE) {
    $color_array = $this->colorPlateThree();
    $plate_array[1] = 'bfbfbf';

    for ($i = 1; $i < 4; $i++) {
      $plate_array[$i + 1] = $color_array[$i];
    }

    $output = $this->colorPlateOutput($plate_array, $key, $pound_sign, 'f6f6f6');
    return $output;
  }

  public function colorPlateSeven($key = NULL, $pound_sign = FALSE) {
    $plate_array = array(
      '1' => 'f24b99',
      '2' => 'f8971d',
      '3' => 'f7d417',
      '4' => 'c6c6c6',
      '5' => '05d23e',     // 5
      '6' => '75d1e0',
      '7' => '2fa9e0',     // 7
      '8' => 'ef1a9d',
      '9' => 'bfbfbf',
    );

    $output = $this->colorPlateOutput($plate_array, $key, $pound_sign, 'f6f6f6');
    return $output;
  }

  public function colorPlateSevenPlus($key = NULL, $pound_sign = FALSE) {
    $color_array = $this->colorPlateSeven();
    $plate_array[1] = 'bfbfbf';

    for ($i = 1; $i < 9; $i++) {
      $plate_array[$i + 1] = $color_array[$i];
    }

    $output = $this->colorPlateOutput($plate_array, $key, $pound_sign, 'f6f6f6');
    return $output;
  }

  /**
   * @param $pound_sign (#)
   */
  public function colorPlatePieChartOne($key = NULL, $pound_sign = FALSE) {
    $plate_array = array(
      '1' => '0093d0',
      '2' => '002596',
      '3' => 'cc292b',
      '4' => '00aeef',
      '5' => '7dba00',
      '6' => 'c6c6c6',
      '7' => '',
      '8' => '',
    );

    $output = $this->colorPlateOutput($plate_array, $key, $pound_sign, 'f6f6f6');
    return $output;
  }

  /**
   * @param $pound_sign (#)
   */
  public function colorPlateDoughnutChartOne($key = NULL, $pound_sign = FALSE) {
    $plate_array = array(
      '1' => '0093d0',
      '2' => 'c6c6c6',
      '3' => '00aeef',
      '4' => '7dba00',
      '5' => '4a245e',
      '6' => '',
      '7' => '',
      '8' => '',
    );

    $output = $this->colorPlateOutput($plate_array, $key, $pound_sign, 'f6f6f6');
    return $output;
  }

  /**
   * @param $pound_sign (#)
   */
  public function colorPlateDoughnutChartTwo($key = NULL, $pound_sign = FALSE) {
    $plate_array = array(
      '1' => '0093d0',
      '2' => '75d1e0',
      '3' => '00aeef',
      '4' => '7dba00',
      '5' => '4a245e',
      '6' => '',
      '7' => '',
      '8' => '',
    );

    $output = $this->colorPlateOutput($plate_array, $key, $pound_sign, 'f6f6f6');
    return $output;
  }

  /**
   * @param $pound_sign (#)
   */
  public function colorPlateLineChartOne($key = NULL, $pound_sign = FALSE) {
    $plate_array = array(
      '1' => '00134b',
      '2' => '0093d0',
      '3' => '00aeef',
      '4' => '7dba00',
      '5' => 'c6c6c6',
      '6' => 'd6006e',
      '7' => '',
      '8' => '',
    );

    $output = $this->colorPlateOutput($plate_array, $key, $pound_sign, 'f6f6f6');
    return $output;
  }

  /**
   * @param $pound_sign (#)
   */
  public function colorPlateBarChartOne($key = NULL, $pound_sign = FALSE) {
    $plate_array = array(
      '1' => '75d1e0',
      '2' => '0093d0',
      '3' => '616365',
      '4' => '7dba00',
      '5' => '4a245e',
      '6' => '',
      '7' => '',
      '8' => '',
    );

    $output = $this->colorPlateOutput($plate_array, $key, $pound_sign, 'f6f6f6');
    return $output;
  }

}
