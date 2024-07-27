# Single Responsibility

За принципом Single Responsibility проведіть рефакторинг класу так щоб у вас був клас для роботи з продуктом, для обробки продукту та для виведення продукту.

Без реалізації коду методів

```
class Product {
  public function get(name) {}
  public function set(name, value) {}
  public function save() {}
  public function update() {}
  public function delete() {}
  public function show() {}
  public function print() {}
}
```