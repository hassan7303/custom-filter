
document.querySelectorAll(".tab-button").forEach(function (button) {
    button.addEventListener("click", function () {
        var tabId = this.getAttribute("data-tab");

        // مخفی کردن همه تب‌ها
        document.querySelectorAll(".tab-content").forEach(function (content) {
            content.classList.remove("active");
        });

        // غیرفعال کردن همه دکمه‌های تب
        document.querySelectorAll(".tab-button").forEach(function (btn) {
            btn.classList.remove("active");
        });

        // نمایش تب انتخاب شده
        document.getElementById("tab-" + tabId).classList.add("active");
        this.classList.add("active");
    });
});

// تابع جستجو
function searchFilters(tabId) {
    var form = document.getElementById("search-form-" + tabId);
    var filters = new FormData(form);

    const filter_1 = form.querySelector(`select[name="brand_car_light"], select[name="brand_car_heavy"],select[name="API"]`).value;
    const filter_2 = form.querySelector(`select[name="car_light"], select[name="car_heavy"],select[name="SAE"]`).value;
    let category

    let flag = false
    let flag2 = false

    if (tabId == 1 || tabId == 2) {

        category = form.querySelector('select[name="product-category"]').value;

        if (category) {
            flag = true
        } else {
            flag2 = true
        }

    }

    let home_url = "<?= home_url() ?>"
    let url

    if (flag) {
        jQuery.ajax({
            type: 'POST',
            url: "<?= home_url('wp-admin/admin-ajax.php')  ?>",
            data: {
                action: 'get_category_slug',
                term_id: category
            },
            success: function (response) {
                window.location.href = home_url + "/product-category/" + response + '?filter_brand=' + filter_1 + '&' + 'filter_car=' + filter_2;
            },
            error: function (error) {
                alert('خطایی رخ داده است')
            }
        });
    } else {
        if (flag2) {
            window.location.href = home_url + '/shop/?filter_brand=' + filter_1 + '&' + 'filter_car=' + filter_2;
        } else {
            window.location.href = home_url + '/shop/?filter_api=' + filter_1 + '&' + 'filter_sae=' + filter_2;
        }
    }
}


const car_data = <?= json_encode($car_data) ?>; // داده‌ها را به صورت JSON تبدیل کنید
const carArray = Array.isArray(car_data) ? car_data : Object.values(car_data);
let brands = []; // آرایه برای ذخیره برندها

carArray.forEach((e) => {
    // جدا کردن slug بر اساس '-'
    const slugParts = e.slug.split('-');
    if (slugParts.length > 1) {
        brands.push({ // از push برای اضافه کردن به آرایه استفاده کنید
            brand: slugParts[1],
            slug: e.slug,
            name:e.name,
        });
    }
});


function updateCarLightOptions(){
    updateOptions("brand_car_light",'car_light' ,brands)
}
function updateCarHeavyOptions(){
    updateOptions("brand_car_heavy",'car_heavy' ,brands)
}
function updateOptions(elementId,car,brands) {
    let selectElement = document.getElementById(elementId).value;
    let split_selectElement = selectElement.split('-');
    let selectedBrand = split_selectElement[1]; // برند انتخاب شده

    if (!selectedBrand) return;

    let carHeavySelect = document.getElementById(car);
    carHeavySelect.innerHTML = '<option value="">انتخاب ماشین</option>'; // اضافه کردن گزینه پیش‌فرض

    // اضافه کردن گزینه‌ها به select بر اساس برند انتخاب شده
    brands.forEach((item) => {
        if (item.brand === selectedBrand) { // اگر برند با برند انتخاب شده برابر بود
            let option = document.createElement("option");
            option.value = item.slug; // مقدار slug را برای گزینه قرار می‌دهیم
            option.textContent = item.name; // نام ماشین را برای نمایش در گزینه قرار می‌دهیم
            carHeavySelect.appendChild(option); // گزینه را به select اضافه می‌کنیم
        }
    });
}
