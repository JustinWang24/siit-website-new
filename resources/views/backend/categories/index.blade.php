@extends('layouts.backend')

@section('content')
    <div id="categories-manager-app" class="content">
        <br>
        <div class="columns">
            <div class="column is-one-fifth">
                <h2 class="is-size-4">
                    {{ trans('admin.menu.categories') }} {{ trans('admin.mgr') }}
                </h2>
                <br>
                <el-tree
                        :data="categories"
                        :props="defaultProps"
                        v-on:node-click="handleEdit"
                        ref="tree"
                        highlight-current
                        :render-content="renderCategoryLabel"
                >
                </el-tree>
            </div>
            <div class="column is-four-fifth">
                <div class="columns">
                    <div class="column">
                        <div class="high-light-box">
                            Current category: <span class="text-danger">@{{ currentSelectedCategoryName }}</span>
                        </div>
                    </div>
                    <div class="column">
                        <el-button class="is-pulled-right" type="primary" v-on:click="createNewCategoryForm">
                            <i class="el-icon-plus"></i>&nbsp; New Category
                        </el-button>
                        <el-button class="is-pulled-right mr-20" type="default" v-on:click="createNewRootCategoryForm">
                            <i class="el-icon-plus"></i>&nbsp; New Root Category
                        </el-button>
                        <el-button class="is-pulled-right mr-20" type="danger" v-on:click="dialogVisible = true">
                            <i class="el-icon-delete"></i>&nbsp; Delete
                        </el-button>
                    </div>
                </div>
                <hr>
                <div class="content">
                    <el-form ref="currentCategory" :rules="rules" :model="currentCategory" label-width="160px">
                        <el-form-item label="Category Name" prop="name">
                            <el-input placeholder="Category name: Required" v-model="currentCategory.name"></el-input>
                        </el-form-item>
                        <el-form-item label="Category Name">
                            <el-input placeholder="中文名称: 选填" v-model="currentCategory.name_cn"></el-input>
                        </el-form-item>
                        <el-form-item label="Category URI" prop="uri">
                            <el-input placeholder="目录链接URI: 必填" v-model="currentCategory.uri"></el-input>
                        </el-form-item>

                        <el-form-item label="In Menu bar">
                            <el-switch v-model="currentCategory.include_in_menu"></el-switch>
                        </el-form-item>

                        <el-form-item label="As static link">
                            <el-switch v-model="currentCategory.as_link"></el-switch>
                        </el-form-item>

                        <el-form-item label="Position" prop="position">
                            <el-input placeholder="排序: 选填 默认为0" v-model="currentCategory.position"></el-input>
                        </el-form-item>

                        <el-form-item label="Short Description" required>
                            <vuejs-editor
                                    ref="categoryShortDescriptionEditor"
                                    class="rich-text-editor"
                                    placeholder="Category short description: Required"
                                    text-area-id="category-short-description-editor"
                                    :original-content="currentCategory.short_description"
                            ></vuejs-editor>
                        </el-form-item>
                        <el-form-item label="目录中文简述">
                            <vuejs-editor
                                    ref="categoryShortDescriptionCnEditor"
                                    class="rich-text-editor"
                                    placeholder="(选填) 目录的中文简要描述"
                                    text-area-id="category-short-description-cn-editor"
                                    :original-content="currentCategory.short_description_cn"
                            ></vuejs-editor>
                        </el-form-item>
                        <hr>
                        <h5 class="desc-text">Optional: For SEO <span class="has-text-danger">({{ trans('general.seo_description_note') }})</span></h5>
                        <el-form-item label="Keywords(SEO)">
                            <el-input placeholder="Optional: use comma to seperate multiple keywords for SEO" type="textarea" v-model="currentCategory.keywords"></el-input>
                        </el-form-item>
                        <el-form-item label="Description(SEO)">
                            <el-input placeholder="Optional: SEO decription" type="textarea" v-model="currentCategory.seo_description"></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-button :loading="savingCategory" type="primary" v-on:click="saveCurrentCategory('currentCategory')">Save<i class="el-icon-upload el-icon--right"></i></el-button>
                            <el-button>Reset</el-button>
                        </el-form-item>
                    </el-form>
                </div>
            </div>
        </div>
        <el-dialog title="Important" :visible.sync="dialogVisible" width="30%">
              <span>Are you sure to delete this category?</span>
              <span slot="footer" class="dialog-footer">
                  <el-button v-on:click="dialogVisible = false">Cancel</el-button>
                  <el-button type="danger" v-on:click="deleteSelectedCategory">Yes</el-button>
              </span>
        </el-dialog>
    </div>
@endsection
