<h5 class="desc-text">基本信息</h5>

<el-form-item label="Course Type" class="select">
    <select v-model="product.type" placeholder="请选择">
        @foreach(\App\Models\Utils\ProductType::All() as $key=>$type)
            <option value="{{ $key }}">{{ $type }}</option>
        @endforeach
    </select>
</el-form-item>
<el-form-item class="select" label="Which Group?" v-show="product.type=={{\App\Models\Utils\ProductType::$GROUP_SPECIFIED}}">
    <select v-model="product.group_id" placeholder="请选择">
        @foreach($groups as $group)
            <option value="{{ $group->id }}">{{ $group->name }}</option>
        @endforeach
    </select>
</el-form-item>

<el-form-item label="Course Name" prop="name" required>
    <el-input placeholder="名称: 必填" v-model="product.name"></el-input>
</el-form-item>
<el-form-item label="Course SKU" prop="sku" required>
    <el-input placeholder="Stock Keeping Unit: 必填" v-model="product.sku"></el-input>
</el-form-item>
<el-form-item label="Course URI">
    <el-input placeholder="课程的URL链接: 必填" v-model="product.uri"></el-input>
</el-form-item>
<el-form-item label="Position" prop="position" required>
    <el-input placeholder="排序: 选填 默认为0" v-model="product.position"></el-input>
</el-form-item>

<el-form-item label="Campus">
    <el-autocomplete
        class="inline-input is-pulled-left"
        v-model="product.brand"
        :fetch-suggestions="brandSearch"
        placeholder="请输入校区"
        :trigger-on-focus="true"
        @select="handleSelectBrand"
    ></el-autocomplete>

    <div v-if="currentBrandImage" class="is-pulled-left ml-20">
        <img :src="currentBrandImage" class="image is-pulled-left" style="height: 40px;">
        <span style="margin-top: 8px;" class="ml-20 is-pulled-left tag is-success" v-if="currentBrand.status">上线</span>
        <span style="margin-top: 8px;" class="ml-20 is-pulled-left tag is-danger" v-if="!currentBrand.status">下线</span>
        <span style="margin-top: 8px;" class="ml-20 is-pulled-left tag is-primary" v-if="currentBrand.promotion">推广品牌</span>
    </div>
</el-form-item>

<el-form-item label="Campus Division">
    <el-select v-model="selectedBrandSerialId"
               :disabled="!brandSerials || brandSerials.length==0"
               placeholder="课程所属校区的分校区"
               v-on:change="brandSerialChanged"
            >
        <el-option
                v-for="item in brandSerials"
                :key="item.id"
                :label="item.name"
                :value="item.id"
                >
        </el-option>
    </el-select>
</el-form-item>

<el-form-item label="Short Description">
    <vuejs-editor
            ref="productShortDescriptionEditor"
            class="rich-text-editor"
            text-area-id="product-short-description-editor"
            :original-content="product.short_description"
            image-upload-url="/api/images/upload"
            existed-images="/api/images/load-all"
            short-codes-load-url="/api/widgets/load-short-codes"
            placeholder="(必填) Course Short Description"
    ></vuejs-editor>
</el-form-item>

<el-form-item label="Description">
    <vuejs-editor
            ref="productDescriptionEditor"
            class="rich-text-editor"
            text-area-id="product-description-editor"
            :original-content="product.description"
            image-upload-url="/api/images/upload"
            existed-images="/api/images/load-all"
            short-codes-load-url="/api/widgets/load-short-codes"
            placeholder="(必填) Course Description"
    ></vuejs-editor>
</el-form-item>
