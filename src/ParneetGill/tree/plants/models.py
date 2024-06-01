from django.db import models
from django.contrib.auth.models import User

class Plant(models.Model): # this defines the structure iof my database, fileds and what will be and what type of data will be stored. 
    name = models.CharField(max_length=255)
    description = models.TextField()
    image_url = models.URLField()
    user = models.ForeignKey(User, on_delete=models.CASCADE, related_name='plants')

    def __str__(self):
        return self.name

