import { defineStore } from 'pinia';
import { ref } from 'vue';
import $axios from '@/axios';

export const useOrderStore = defineStore('orders', () => {
  const orders = ref([]);
  const latestOrder = ref(null);
  const orderItems = ref([]);
  const error = ref(null);

  // Orders
  const fetchOrders = async () => {
    try {
      const response = await $axios.get('orders');
      console.log('Orders API response:', response.data);
      orders.value = response.data;
      return orders.value;
    } catch (err) {
      error.value = 'Failed to fetch orders';
      return [];
    }
  };

  const addOrder = async (orderData) => {
    try {
      const response = await $axios.post('/orders', orderData);
      return response.data;
    } catch (err) {
      error.value = 'Failed to add order';
      return null;
    }
  };

  const fetchLatestOrder = async () => {
    try {
      const response = await $axios.get('/orders/latest');
      latestOrder.value = response.data;
      return latestOrder.value;
    } catch (err) {
      error.value = 'Failed to fetch latest order';
      return null;
    }
  };

  // Order Items
  const fetchOrderItems = async () => {
    try {
      const response = await $axios.get('/orderitems');
      orderItems.value = response.data;
      return orderItems.value;
    } catch (err) {
      error.value = 'Failed to fetch order items';
      return [];
    }
  };

  const fetchOrderItemsByOrderId = async (orderId) => {
    try {
      const response = await $axios.get(`/orderitems/order/${orderId}`);
      return response.data;
    } catch (err) {
      error.value = 'Failed to fetch order items by order ID';
      return [];
    }
  };

  const addOrderItem = async (orderItemData) => {
    try {
      const response = await $axios.post('/orderitems', orderItemData);
      return response.data;
    } catch (err) {
      error.value = 'Failed to add order item';
      return null;
    }
  };

  const fetchOrdersByUserId = async (userId) => {
    try {
      const response = await $axios.get(`/orders/user/${userId}`);
      orders.value = response.data;
      return orders.value;
    } catch (err) {
      error.value = 'Failed to fetch user orders';
      return [];
    }
  };

  const placeOrder = async ({ userId, cartItems, total }) => {
    // 1. Create the order
    const orderRes = await $axios.post('/orders', {
      userId,
      total_amount: total,
      status: 'pending',
    });
    const orderId = orderRes.data.order.id;

    // 2. Create order items
    for (const item of cartItems) {
      await $axios.post('/orderitems', {
        orderId,
        materialId: item.product.id,
        quantity: item.quantity,
        price: item.product.price,
      });
    }

    return orderId;
  };

  return {
    orders,
    latestOrder,
    orderItems,
    error,
    fetchOrders,
    addOrder,
    fetchLatestOrder,
    fetchOrderItems,
    fetchOrderItemsByOrderId,
    addOrderItem,
    fetchOrdersByUserId,
    placeOrder,
  };
});
