<?php
    namespace Database\Factories;

    use App\Models\Product;
    use Illuminate\Database\Eloquent\Factories\Factory;

    class ProductFactory extends Factory
    {
        protected $model = Product::class;

        public function definition()
        {
            return [
                'name' => $this->faker->name,
                'price' => $this->faker->randomFloat(2, 10, 1000),
                'description' => $this->faker->sentence,
            ];
        }
    }


?>