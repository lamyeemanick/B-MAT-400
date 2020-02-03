/*
** EPITECH PROJECT, 2019
** 209poll_2018
** File description:
** SFML
*/

#ifndef SFML_HPP_
#define SFML_HPP_

#include <SFML/Graphics.hpp>

class SFML {
	public:
		SFML();
		~SFML();
        
        bool isRunning();
        void clear();

        int drawStart();

        void beforeStarting(std::string const &filename1, std::string const &filename2);
        int drawMain(std::string &data);

        void drawPoll(int population, std::string const &data);

        std::string updateLeft(std::string &data);
        std::string updateRight(std::string &data);

	protected:
	private:
        int _lorr;
        sf::RenderWindow _window;
        sf::Event _event;
        sf::Font _font;
        sf::Text _stats;

        sf::Sprite _box;
        sf::Texture _background;
        sf::Sprite _white;
        sf::Texture _poll;

        sf::Sprite _c1;
        sf::Texture _concurrent1;
        sf::Sprite _c2;
        sf::Texture _concurrent2;
};

#endif /* !SFML_HPP_ */
