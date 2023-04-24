<template>
    <div>
        <div>
            <label>
                <div class="form-group">
                    <input type="text" v-model="title" name="title" required :class="{ accept: !$v.title.$invalid }">
                    <div class="error">Title <span v-if="!$v.title.required"> is required.</span><span v-if="!$v.title.minLength"> must be at least 4 characters.</span></div>
                </div>
            </label>
        </div>
        <div>
            <label>
                <div class="form-group">
                    <select name="category" v-model="category" required>
                        <option value="" disabled>-- Select One --</option>
                        <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                        <option disabled>--</option>
                        <option value="new">Create New Category</option>
                    </select>
                    <div class="error">Category <span v-if="!$v.category.required"> is required.</span></div>
                </div>
            </label>
        </div>
        <div v-show="category == 'new'">
            <label>
                <div class="form-group">
                    <input autofocus type="text" name="category_name">
                    <div class="error">Category Name <span v-if="!$v.category.required"> is required.</span></div>
                </div>
            </label>
        </div>
        <div>
            <label>
                <div class="form-group">
                    <wysiwyg v-model="content" />
                </div>
            </label>
        </div>
        <button class="button" type="submit" :disabled="$v.$invalid">Create Page</button>
    </div>
</template>

<script>
    import { required, minLength, between } from 'vuelidate/lib/validators'

    export default {
        data() {
            return {
                title: '',
                categories: [],
                category: '',
                content: ''
            }
        },
        validations: {
            title: {
              required,
              minLength: minLength(4)
            },
            category: {
              required
            }
        },
        mounted() {
            axios.get(this.$root.fetch("categories")).then((response) => {
                this.categories = response.data;
            }).catch( error => { console.log(error); });
        }
    }
</script>
