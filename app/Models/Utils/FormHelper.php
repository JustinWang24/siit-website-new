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

    private function _i18n($model=null,$key){
        $model = $model ? $model : 'enrolment';
        return trans($model.'.'.$key);
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
    public function simpleTextField($modelName,$fieldName, $isRequired = true, $fieldValue=null, $placeholder=null, $label=null, $isReadOnly=false){
        if(is_null($placeholder)){
            $placeholder = $this->_i18n($modelName,$fieldName.'_placeholder');
        }

        if(is_null($label)){
            $label = $this->_i18n($modelName,$fieldName);
        }
        if($isRequired){
            $placeholder = trans('general.Required').': '.$placeholder;
            $label = $label.' <span class="has-text-danger">*</span>';
        }else{
            $placeholder = trans('general.Optional').': '.$placeholder;
        }

        $type = $fieldName=='password'?'password':'text';
        if($fieldName == 'birthday' || strpos($fieldName,'date') !== false){
            $type = 'date';
            $placeholder .= ' 1999-01-31';
        }
        ?>
        <div class="field">
            <label class="label"><?php echo $label; ?></label>
            <div class="control">
                <input name="<?php echo $modelName.'['.$fieldName.']'; ?>" class="input" type="<?php echo $type; ?>" placeholder="<?php echo $placeholder; ?>" value="<?php echo $fieldValue; ?>"<?php echo $isRequired?' required':null ?><?php echo $isReadOnly?' readonly':null ?>>
            </div>
        </div>
        <?php
    }

    /**
     * 生成最基本的下拉列表表单
     * @param string $modelName
     * @param string $fieldName
     * @param array $fieldOptions
     * @param null $defaultValue
     * @param bool $isRequired
     * @param null $label
     */
    public function simpleSelectField($modelName,$fieldName, $fieldOptions=[], $defaultValue=null, $isRequired=true, $label=null){
        if(is_null($label)){
            $label = $this->_i18n($modelName,$fieldName);
        }
        if($isRequired){
            $label = $label.' <span class="has-text-danger">*</span>';
        }
        $options = '';
        foreach ($fieldOptions as $value=>$text) {
            $options .= '<option value="'.$value.'" '.($defaultValue==$value?'selected':null).'>'.$text.'</option>';
        }
        ?>
        <div class="field">
            <label class="label"><?php echo $label; ?></label>
            <div class="control">
                <div class="select">
                    <select name="<?php echo $modelName.'['.$fieldName.']'; ?>"<?php echo $isRequired?' required':null ?>><?php echo $options; ?></select>
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
     * @param null $defaultFilePath 默认的已经存在的文件路径
     * @param boolean $allowMultiple 是否可以上传多个文件
     */
    public function simpleFileField($fieldName, $isRequired=true, $label=null,$defaultFilePath=null,$allowMultiple=false){
        if($isRequired){
            $label = $label.' <span class="has-text-danger">*</span>';
        }
        $fileElementId = 'input_'.$fieldName;
        $fileNameElementId = $fileElementId.'_name';
        $onFileChangeCodes = 'if(this.files.length>0){document.getElementById(\''.$fileNameElementId.'\').innerHTML = this.files[0].name;};';
        if($allowMultiple){
            $onFileChangeCodes = 'if(this.files.length>0){document.getElementById(\''.$fileNameElementId.'\').innerHTML = this.files.length+\' files are selected.\';};';
        }
        ?>
        <div class="field">
            <label class="label"><?php echo $label; ?></label>
            <div class="control">
                <div class="file has-name">
                    <label class="file-label">
                        <input<?php echo $allowMultiple?' multiple':null ?> id="<?php echo $fileElementId; ?>" class="file-input" type="file" name="<?php echo $fieldName; ?><?php echo $allowMultiple?'[]':null; ?>"<?php echo $isRequired?' required':null ?> onchange="<?php echo $onFileChangeCodes; ?>">
                        <span class="file-cta">
                          <span class="file-icon"><i class="fas fa-upload"></i></span>
                          <span class="file-label"><?php echo $allowMultiple? trans('general.Choose_files'):trans('general.Choose_files') ?></span>
                        </span>
                        <span class="file-name" id="<?php echo $fileNameElementId; ?>"></span>
                    </label>
                    <?php
                    if($defaultFilePath){
                        ?><p><a href="<?php echo asset($defaultFilePath) ?>" target="_blank">View my uploaded file</a></p><?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}