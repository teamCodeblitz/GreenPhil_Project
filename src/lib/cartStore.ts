// src/lib/cartStore.ts
import { writable } from 'svelte/store';

export interface CartItem {
    id: number;
    name: string;
    price: number;
    quantity: number;
    image: string;
}

const cart = writable<CartItem[]>([]);

export const addToCart = (product: CartItem) => {
    cart.update(items => {
        const existingItem = items.find(item => item.id === product.id);
        if (existingItem) {
            return items.map(item => 
                item.id === product.id 
                    ? { ...item, quantity: item.quantity + 1 }
                    : item
            );
        } else {
            return [...items, { ...product, quantity: 1 }];
        }
    });
};

export const removeFromCart = (id: number) => {
    cart.update(items => items.filter(item => item.id !== id));
};

export const updateQuantity = (id: number, newQuantity: number) => {
    if (newQuantity < 1) return;
    cart.update(items => {
        return items.map(item => 
            item.id === id ? { ...item, quantity: newQuantity } : item
        );
    });
};

export const cartStore = cart;