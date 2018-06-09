<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 7/6/18
 * Time: 5:06 PM
 */

namespace App\Models\Utils;


class FormHelper
{
    private static $INSTANCE = null;
    private $theme;

    const THEME_BULMA = 'BULMA';
    const THEME_TWITTER_BOOTSTRAP4 = 'tw4';

    /**
     * 构造函数， 默认使用bulma主题
     * FormHelper constructor.
     */
    private function __construct()
    {
        $this->theme = self::THEME_BULMA;
    }

    public static function getInstance(){
        if(self::$INSTANCE == null){
            self::$INSTANCE = new FormHelper();
        }
        return self::$INSTANCE;
    }

    /**
     * 输出最基本的 text field
     * @param $modelName
     * @param $fieldName
     * @param bool $isRequired
     * @param null $fieldValue
     * @param null $placeholder
     * @param null $label
     */
    public function simpleTextField($modelName,$fieldName, $isRequired = true, $fieldValue=null, $placeholder=null, $label=null){
        if(is_null($placeholder)){
            $placeholder = ucwords(str_replace('_',' ',$fieldName));
        }

        if(is_null($label)){
            $label = ucwords(str_replace('_',' ',$fieldName));
        }
        if($isRequired){
            $placeholder = 'Required: '.$placeholder;
            $label = $label.' <span class="has-text-danger">*</span>';
        }else{
            $placeholder = 'Optional: '.$placeholder;
        }
        ?>
        <div class="field">
            <label class="label"><?php echo $label; ?></label>
            <div class="control"><input name="form[<?php echo $fieldName; ?>]" class="input" type="text" placeholder="<?php echo $placeholder; ?>" value="<?php echo $fieldValue; ?>"<?php echo $isRequired?' required':null ?>></div>
        </div>
        <?php
    }

    /**
     * 生成最基本的下拉列表表单
     * @param $fieldName
     * @param array $fieldOptions
     * @param null $defaultValue
     * @param bool $isRequired
     * @param null $label
     */
    public function simpleSelectField($modelName,$fieldName, $fieldOptions=[], $defaultValue=null, $isRequired=true, $label=null){
        if(is_null($label)){
            $label = ucwords(str_replace('_',' ',$fieldName));
        }
        if($isRequired){
            $label = $label.' <span class="has-text-danger">*</span>';
        }
        $options = '';
        foreach ($fieldOptions as $value=>$text) {
            $options .= '<option value="'.$value.'" '.($defaultValue===$value?'selected':null).'>'.$text.'</option>';
        }
        ?>
        <div class="field">
            <label class="label"><?php echo $label; ?></label>
            <div class="control">
                <div class="select">
                    <select name="form[<?php echo $fieldName; ?>]"<?php echo $isRequired?' required':null ?>><?php echo $options; ?></select>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * 生成最基本的文件上传field
     * @param $fieldName
     * @param bool $isRequired
     * @param null $label
     */
    public function simpleFileField($modelName,$fieldName, $isRequired=true, $label=null){
        if(is_null($label)){
            $label = ucwords(str_replace('_',' ',$fieldName));
        }
        if($isRequired){
            $label = $label.' <span class="has-text-danger">*</span>';
        }
        $fileElementId = uniqid($fieldName);
        $fileNameElementId = uniqid($fieldName.'-name');
        $jsFileVariableName = uniqid($fieldName.'file_');
        ?>
        <div class="field">
            <label class="label"><?php echo $label; ?></label>
            <div class="control">
                <div class="file has-name">
                    <label class="file-label">
                        <input id="<?php echo $fileElementId; ?>" class="file-input" type="file" name="<?php echo $fieldName; ?>"<?php echo $isRequired?' required':null ?>>
                        <span class="file-cta">
                          <span class="file-icon">
                            <i class="fas fa-upload"></i>
                          </span>
                          <span class="file-label">
                            Choose a file…
                          </span>
                        </span>
                        <span class="file-name" id="<?php echo $fileNameElementId; ?>"></span>
                    </label>
                </div>
            </div>
            <script type="application/javascript">
                var <?php echo $jsFileVariableName ?> = document.getElementById("<?php echo $fileElementId; ?>");
                <?php echo $jsFileVariableName ?>.onchange = function(){
                    if(<?php echo $jsFileVariableName ?>.files.length > 0){document.getElementById('<?php echo $fileNameElementId; ?>').innerHTML = <?php echo $jsFileVariableName ?>.files[0].name;}
                };
            </script>
        </div>
        <?php
    }
}