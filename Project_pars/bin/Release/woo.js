const WooCommerceRestApi = require("@woocommerce/woocommerce-rest-api").default;
const fs = require('fs').promises;
const path = require('path');

const WooCommerce = new WooCommerceRestApi({
  url: 'https://spares24.eu/',
  consumerKey: 'ck_cd68672d6ddf23b56d399aea7a68cdf45e43f170',
  consumerSecret: 'cs_757e3f901576f95bc3970831add27defae5f188d',
  version: 'wc/v3'
});


// Аутентификационные данные для WordPress
const WPUsername = 'Spares84';
const WPPassword = 'ibkM TeYG IOBl qlM7 6CV5 tVCy';

// Функция для загрузки изображения и обновления его метаданных
const uploadAndUpdateImage = async (imagePath, oeCode, index) => {
  const fileContent = await fs.readFile(imagePath);
  const filename = `image_${index}_${path.basename(imagePath)}`;
  const uploadUrl = 'https://spares24.eu/wp-json/wp/v2/media';
  
  // Загрузка файла
  const uploadResponse = await fetch(uploadUrl, {
      method: 'POST',
      headers: {
          'Authorization': 'Basic ' + Buffer.from(`${WPUsername}:${WPPassword}`).toString('base64'),
          'Content-Disposition': `attachment; filename="${filename}"`,
          'Content-Type': 'image/jpeg'
      },
      body: fileContent
  });
  
  const uploadData = await uploadResponse.json();
  
  // Обновление метаданных загруженного изображения
  const updateUrl = `https://spares24.eu/wp-json/wp/v2/media/${uploadData.id}`;
  const metaData = {
      title: `${oeCode} ${index}`,
      alt_text: `${oeCode} ${index}`,
      caption: `Image ${index} for ${oeCode}`,
      description: `This is image number ${index} for OE code ${oeCode}.`
  };

  const updateResponse = await fetch(updateUrl, {
      method: 'POST',
      headers: {
          'Authorization': 'Basic ' + Buffer.from(`${WPUsername}:${WPPassword}`).toString('base64'),
          'Content-Type': 'application/json'
      },
      body: JSON.stringify(metaData)
  });

  const updateData = await updateResponse.json();
  console.log('Metadata updated:', updateData);
  return updateData.id; // Возвращаем ID обновленного изображения
};

const uploadImagesFromDirectoryAndUpdate = async (directoryPath, oeCode) => {
  const files = await fs.readdir(directoryPath);
  const imageIds = [];

  let index = 1; // Начинаем с 1
  for (const file of files) {
    const filePath = path.join(directoryPath, file);
    // Передаем текущий индекс как часть имени файла
    const imageId = await uploadAndUpdateImage(filePath, oeCode, index);
    imageIds.push({ id: imageId });
    index++; // Увеличиваем индекс для следующего файла
  }
  
  return imageIds;
};



async function ensureTagsExist(codes) {
    const tagIds = [];
  
    for (const code of codes) {
      try {
        // Проверяем существование тега
        let tagResponse = await WooCommerce.get("products/tags", { search: code });
        let tagId;
  
        if (tagResponse.data.length === 0) {
          // Создаем новый тег, если он не найден
          let newTag = await WooCommerce.post("products/tags", { name: code });
          tagId = newTag.data.id;
        } else {
          tagId = tagResponse.data[0].id;
        }
  
        tagIds.push({ id: tagId });
      } catch (error) {
        console.error(`Ошибка при работе с тегом ${code}:`, error);
      }
    }
  
    return tagIds;
  }
  
async function ensureCategoryExists(categoryName) {
  try {
    const response = await WooCommerce.get("products/categories", { search: categoryName });
    const categories = response.data;
    if (categories.length === 0) {
      const newCategoryResponse = await WooCommerce.post("products/categories", { name: categoryName });
      return newCategoryResponse.data.id;
    } else {
      return categories[0].id;
    }
  } catch (error) {
    console.error("Ошибка при работе с категориями:", error);
    throw error;
  }
}
async function getTagIdsByCodes(codes) {
    // Здесь должна быть реализация получения ID тегов по кодам
    return codes.map(code => ({ id: Math.floor(Math.random() * 1000) })); // Пример реализации
  }

  async function createOrUpdateProduct(filename) {
    try {
      const jsonData = await fs.readFile(filename, 'utf8');
      const productData = JSON.parse(jsonData);
      const codesArray = productData.codes.split(',').map(code => code.trim());
      const tagIds = await ensureTagsExist(codesArray);
  
      // Проверяем существование продукта по SKU
      const response = await WooCommerce.get("products", { sku: productData.sku });
      const existingProduct = response.data.length > 0 ? response.data[0] : null;
      const imagesDirectoryPath = path.join(__dirname, 'img');
      var atr;
     
      if (productData.oe == null){
        atr = productData.sku;
      }else{
        atr = productData.oe;
      }
      const imagesIds = await uploadImagesFromDirectoryAndUpdate(imagesDirectoryPath, atr + "_" + 1);
  
      // Категория
      const categoryId = await ensureCategoryExists(productData.categories);
  
      // Преобразуем цену
      const formattedPrice = productData.regularPrice.replace(',', '.');
      const codesOptions = productData.codes ? productData.codes.split(',').map(code => String(code).trim()) : [];
  
  
      // Формируем данные продукта
      const productPayload = {
          name: productData.name,
          type: "simple",
          regular_price: formattedPrice,
          description: productData.description,
          short_description: productData.shortDescription,
          categories: [{ id: categoryId }],
          sku: productData.sku,
          manage_stock: true,
          stock_quantity: productData.stock,
          images: imagesIds.map(({ id }) => ({ id })),
          attributes: [
            {
              name: "Manufacturer",
              options: [String(productData.manufacturer)], // Явное приведение к строке
              visible: true,
              variation: false
            },
            {
              name: "OE",
              options: [String(productData.oe)], // Явное приведение к строке
              visible: true,
              variation: false
            },
            {
              name: "OEM",
              options: codesOptions.map(option => String(option)), // Явное приведение каждого элемента к строке
              visible: true,
              variation: false
            }
          ],
          tags: tagIds.map(tag => ({id: tag.id})) // Убедитесь, что теги формируются корректно
        };
        
  
      if (existingProduct) {
        // Обновляем существующий продукт
        console.log(`Товар с таким sku уже существует. ID: ${existingProduct.id}`);
        //const updatedProduct = await WooCommerce.put(`products/${existingProduct.id}`, productPayload);
        //console.log('Продукт успешно обновлен', updatedProduct.data);
      } else {
        // Создаем новый продукт
        console.log('Создание нового продукта');
        const createdProduct = await WooCommerce.post("products", productPayload);
        console.log('Продукт успешно создан', createdProduct.data);
      }
    } catch (error) {
      console.error('Ошибка:', error.response ? error.response.data : error.message);
    }
  }
  

(async () => {
  try {
    await createOrUpdateProduct('result.json');
  } catch (error) {
    console.error('Error:', error);
  }
})();
