<h5 class="desc-text">中文信息</h5>
<el-form-item label="课程中文名" prop="name_cn">
    <el-input placeholder="名称: 选填" v-model="product.name_cn"></el-input>
</el-form-item>

<el-form-item label="课程简介">
    <vuejs-editor
            ref="productShortDescriptionCNEditor"
            class="rich-text-editor"
            text-area-id="product-short-description-cn-editor"
            :original-content="product.short_description_cn"
            placeholder="(选填) 课程简介-中文"
    ></vuejs-editor>
</el-form-item>

<el-form-item label="课程详情">
    <vuejs-editor
            ref="productDescriptionCNEditor"
            class="rich-text-editor"
            text-area-id="product-description-cn-editor"
            :original-content="product.description_cn"
            placeholder="(选填) 课程详情-中文"
    ></vuejs-editor>
</el-form-item>
