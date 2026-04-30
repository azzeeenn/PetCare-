#!/usr/bin/env python
# coding: utf-8

# In[ ]:





# In[1]:


from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
import os

app = Flask(__name__)
CORS(app)  # Enable CORS for frontend requests

# Database Configuration (Use SQLite or MySQL)
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///pets.db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)

# Pet Model
class Pet(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(255), nullable=False)
    breed = db.Column(db.String(255), nullable=False)
    image = db.Column(db.String(255), nullable=False)

# Initialize the database
with app.app_context():
    db.create_all()

# Route to Add Pet
@app.route('/add_pet', methods=['POST'])
def add_pet():
    name = request.form.get('name')
    breed = request.form.get('breed')
    
    # Handle Image Upload
    if 'image' not in request.files:
        return jsonify({"status": "error", "message": "Image is required"}), 400
    
    image = request.files['image']
    image_path = f'uploads/{image.filename}'
    os.makedirs('uploads', exist_ok=True)
    image.save(image_path)

    new_pet = Pet(name=name, breed=breed, image=image_path)
    db.session.add(new_pet)
    db.session.commit()

    return jsonify({"status": "success", "message": "Pet added successfully"}), 201

# Route to Get All Pets
@app.route('/get_pets', methods=['GET'])
def get_pets():
    pets = Pet.query.all()
    return jsonify([{"id": pet.id, "name": pet.name, "breed": pet.breed, "image": pet.image} for pet in pets])

# Route to Delete Pet
@app.route('/delete_pet', methods=['POST'])
def delete_pet():
    data = request.get_json()
    pet_id = data.get('id')

    pet = Pet.query.get(pet_id)
    if not pet:
        return jsonify({"status": "error", "message": "Pet not found"}), 404
    
    # Remove Image File
    if os.path.exists(pet.image):
        os.remove(pet.image)

    db.session.delete(pet)
    db.session.commit()
    
    return jsonify({"status": "success", "message": "Pet deleted successfully"})

if __name__ == '__main__':
    app.run(debug=True)


# In[3]:





# In[ ]:




