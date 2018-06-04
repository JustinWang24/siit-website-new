@extends(_get_frontend_layout_path('catalog'))
@section('content')
    <div class="container mt-20 pl-10 pr-10 categories-wrapper" id="category-view-manager">
        <div class="columns">
            <div class="column">
                <h1 class="is-size-1 pl-10">{{ $category->name }}</h1>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <br>
                <?php
                $productsChunk = $products->chunk(4);
                foreach ($productsChunk as $row) {
                    ?>
                    <div class="columns">
                        @foreach($row as $key=>$product)
                        <div class="column is-3-desktop is-12-mobile">
                            <div class="content box">
                                <p class="is-pulled-left has-text-left"><a href="{{ url('catalog/brand/load?name='.$product->brand) }}">{{ $product->brand }}</a></p>
                                @if($product->group_id)
                                    <p class="is-pulled-right"><span class="tag is-danger">{{ $product->group->name }}</span></p>
                                @else
                                    <p class="is-pulled-right"><span class="tag is-info">{{ str_replace('_',' ',env('APP_NAME')) }}</span></p>
                                @endif
                                <div class="is-clearfix"></div>
                                    <a href="{{ url('catalog/product/'.$product->uri) }}">
                                    <p>
                                        <img src="{{ $product->getProductDefaultImageUrl() }}" alt="{{ $product->name }}" class="image">
                                    </p>
                                    <div class="price-box">
                                        <p class="is-pulled-left {{ $product->special_price ? 'has-text-grey-lighter' : 'has-text-danger' }} is-size-5">${{ $product->getDefaultPriceGST() }}</p>
                                        @if($product->special_price)
                                            <p class="is-pulled-right has-text-danger is-size-4">${{ $product->getSpecialPriceGST() }}</p>
                                        @endif
                                    </div>
                                    <div class="is-clearfix"></div>
                                    <p class="is-size-6 has-text-grey mb-10 mh48">{{ $product->name }}</p>
                                </a>

                                <div class="control is-pulled-right">
                                    <div class="tags has-addons">
                                        <a class="tag" href="#" v-on:click.prevent="startEnquiry('{{ $product->name }}','{{ $product->uuid }}')">
                                            <i class="far fa-comment"></i>&nbsp;Send Enquiry
                                        </a>
                                    </div>
                                </div>
                                <div class="is-clearfix"></div>
                            </div>
                        </div>

                        @endforeach
                    </div>
                    <?php
                }
                ?>
                
                <div class="content">
                    <div class="is-pulled-right">
                        {{ $cps->appends($paginationAppendParams)->links() }}
                    </div>
                </div>
            </div>
        </div>

            <el-dialog title="Enquiry" :visible.sync="showSendEnquiryForm">
            <el-form :model="enquiryForm" :rules="rules" ref="enquiryDataForm">
                <el-form-item label="Product" :label-width="formLabelWidth">
                    <el-input v-model="enquiryForm.selectedProductName" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="Your Name" v-show="!userIsLocated" :label-width="formLabelWidth" prop="name">
                    <el-input v-model="enquiryForm.name" placeholder="Your Name"></el-input>
                </el-form-item>
                <el-form-item label="Email" v-show="!userIsLocated" :label-width="formLabelWidth" prop="email">
                    <el-input v-model="enquiryForm.email" placeholder="Your Email"></el-input>
                </el-form-item>
                <el-form-item label="Phone" :label-width="formLabelWidth" prop="phone">
                    <el-input v-model="enquiryForm.phone" placeholder="Your phone #"></el-input>
                </el-form-item>
                <el-form-item label="Message" :label-width="formLabelWidth">
                    <el-input type="textarea" v-model="enquiryForm.message" placeholder="Say Something ..."></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="cancelEnquiry">Cancel</el-button>
                <el-button type="primary" @click="sendEnquiryAction('enquiryDataForm')">Submit</el-button>
            </div>
        </el-dialog>
    </div>
@endsection