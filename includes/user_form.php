<form class="order-form" method="post" action="../includes/order.php">
    <h3>Оформление заказа</h3>
    <label>Имя: <input type="text" name="name" required></label><br><br>
    <label>Телефон: <input type="tel" name="phone" required></label><br><br>
    <label>Почта: <input type="email" name="email" required></label><br><br>
    <label>Адрес: <textarea name="address" required></textarea></label><br><br>
    <input type="hidden" name="total_cost" value="<?= $total ?>">
    <button type="submit" name="checkout" class="order-btn">Оформить заказ</button>
  </form>